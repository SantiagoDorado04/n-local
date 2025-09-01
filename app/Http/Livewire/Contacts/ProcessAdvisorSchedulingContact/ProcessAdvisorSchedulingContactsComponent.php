<?php

namespace App\Http\Livewire\Contacts\ProcessAdvisorSchedulingContact;

use App\Models\Challenge;
use App\Models\ContactsChallenge;
use App\Models\InformationForm;
use App\Models\InformationFormAnswer;
use App\Models\ProcessAdvisorScheduling;
use App\Models\ProcessAlquimiaAgent;
use App\Models\ProcessAlquimiaAgentAnswer;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProcessAdvisorSchedulingContactsComponent extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $advisorSchedulingId;
    public $stepId;
    public $step;
    public $contactId;

    public $input;
    public $message = '';
    public $count = 1;


    public $stageActive = false;

    public $incompleteSteps = [];

    public function mount($id)
    {
        $this->step = Step::with('processAdvisorScheduling')->findOrFail($id);
        $this->stepId = $id;

        if ($this->step->stage->active == 1) {
            $this->stageActive = true;
        }
        $this->advisorSchedulingId = $this->step->processAdvisorScheduling->id;

        if (Auth::check() && Auth::user()->role_id == 7) {
            $this->count = 2;
            $this->contactId = Auth::user()->contact->id;
        }
    }


    public function render()
    {
        $advisorScheduling = ProcessAdvisorScheduling::where('step_id', '=', $this->stepId)
            ->first();

        $requirementsMet = $this->checkRequirements();
        return view('livewire..contacts.process-advisor-scheduling-contact.process-advisor-scheduling-contacts-component', [
            'advisorScheduling' => $advisorScheduling,
            'requirementsMet' => $requirementsMet,
            'incompleteSteps' => $this->incompleteSteps,
        ]);
    }

    public function checkRequirements()
    {
        $this->incompleteSteps = [];

        // Pasos requeridos del proceso
        $requiredSteps = json_decode($this->step->processAdvisorScheduling->required_steps, true) ?? [];

        // Contacto (sea el enviado al componente o el usuario autenticado)
        $contactId = $this->contactId ?? (Auth::check() ? Auth::user()->contact->id : null);

        if (!$contactId) {
            // Si no hay contacto, todos los pasos se consideran incompletos
            $this->incompleteSteps = Step::whereIn('id', $requiredSteps)->get();
            return false;
        }

        foreach ($requiredSteps as $requiredStepId) {
            $requiredStep = Step::find($requiredStepId);

            if (!$requiredStep) {
                // Paso inválido (no existe en BD)
                continue;
            }

            $isComplete = true;

            switch ($requiredStep->step_type) {
                case 'F': // Formulario
                    $form = InformationForm::where('step_id', $requiredStep->id)->first();
                    $answered = $form
                        ? InformationFormAnswer::where('information_form_id', $form->id)
                        ->where('contact_id', $contactId)
                        ->exists()
                        : false;
                    $isComplete = $answered;
                    break;

                case 'CD': // Retos y entregables
                    $challenges = Challenge::where('step_id', $requiredStep->id)->get();
                    $allDelivered = true;

                    foreach ($challenges as $challenge) {
                        $delivered = ContactsChallenge::where('challenge_id', $challenge->id)
                            ->where('contact_id', $contactId)
                            ->exists();

                        if (!$delivered) {
                            $allDelivered = false;
                            break;
                        }
                    }
                    $isComplete = $allDelivered && !$challenges->isEmpty();
                    break;

                case 'LZ': // Lienzo
                    $canva = \App\Canva::where('step_id', $requiredStep->id)->first();
                    $answered = $canva
                        ? InformationFormAnswer::where('information_form_id', $canva->information_form_id)
                        ->where('contact_id', $contactId)
                        ->exists()
                        : false;
                    $isComplete = $answered;
                    break;

                case 'AL': // Agente Alquimia
                    $agent = ProcessAlquimiaAgent::where('step_id', $requiredStep->id)->first();
                    $answered = $agent
                        ? ProcessAlquimiaAgentAnswer::where('process_alquimia_agent_id', $agent->id)
                        ->where('contact_id', $contactId)
                        ->exists()
                        : false;
                    $isComplete = $answered;
                    break;

                default:
                    $isComplete = false;
                    break;
            }

            if (!$isComplete) {
                // 🚀 Ahora guardamos el modelo completo, no solo el ID
                $this->incompleteSteps[] = $requiredStep;
            }
        }

        // Devuelve true si TODOS los requisitos están completos
        return empty($this->incompleteSteps);
    }
}
