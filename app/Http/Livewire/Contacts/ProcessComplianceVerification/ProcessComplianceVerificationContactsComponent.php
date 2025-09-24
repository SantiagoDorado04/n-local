<?php

namespace App\Http\Livewire\Contacts\ProcessComplianceVerification;

use App\Models\PContactComplianceVerification;
use App\Models\PComplianceVerificationAnswer;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProcessComplianceVerificationContactsComponent extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $complianceId;
    public $stepId;
    public $compliance;
    public $questions;
    public $contactId;

    public $input;
    public $message = '';
    public $count = 1;

    public $incompleteSteps = [];


    public $stageActive = false;

    public function mount($id)
    {
        $step = Step::with('processComplianceVerification')->findOrFail($id);

        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }
        $this->complianceId = $step->processComplianceVerification->id;
        $this->compliance = $step->processComplianceVerification;
        $this->questions = $this->compliance->questions;

        $this->stepId = $this->compliance->step_id;

        if (Auth::check() && (Auth::user()->role_id == 7 || Auth::user()->role_id == 4)) {
            $this->count = 2;
            $this->contactId = Auth::user()->contact->id;
        }
    }


    public function render()
    {
        $answers = PComplianceVerificationAnswer::where('contact_id', '=', $this->contactId)
            ->where('pc_verification_id', '=', $this->complianceId)
            ->get()
            ->keyBy('question_id');

        /*     dd([
            'contactId' => $this->contactId,
            'complianceId' => $this->complianceId,
            'answers' => $answers,
            'hasAnswers' => $answers->isNotEmpty()
        ]); */

        $requirementsMet = $this->checkRequirements();


        return view('livewire..contacts.process-compliance-verification.process-compliance-verification-contacts-component', [
            'answers' => $answers,
            'compliance' => $this->compliance,
            'hasAnswers' => $answers->isNotEmpty(),
            'requirementsMet' => $requirementsMet,
            'incompleteSteps' => $this->incompleteSteps,
        ]);
    }

    public function submit($formData)
    {
        // Guardar cabecera del formulario
        $contactForm = new PContactComplianceVerification();
        $contactForm->fill([
            'contact_id' => $this->contactId,
            'pc_verification_id' => $this->complianceId,
            'date_completed' => now(),
        ])->save();

        // Guardar respuestas
        foreach ($this->questions as $question) {
            $questionId = 'question_' . $question->id;
            if (isset($formData[$questionId])) {
                $answer = new PComplianceVerificationAnswer();
                $answer->contact_id = $this->contactId;
                $answer->pc_verification_id = $this->compliance->id;
                $answer->question_id = $question->id;
                $answer->answer = $formData[$questionId];
                $answer->save();
            }
        }

        $this->emit('alert', ['type' => 'success', 'message' => '¡Formulario enviado correctamente!']);
    }

    public function checkRequirements()
    {
        $this->incompleteSteps = [];

        // Pasos requeridos del proceso
        $requiredSteps = json_decode($this->compliance->required_steps, true) ?? [];

        // Contacto
        $contactId = $this->contactId ?? (Auth::check() ? Auth::user()->contact->id : null);

        if (!$contactId) {
            $this->incompleteSteps = Step::whereIn('id', $requiredSteps)->get();
            return false;
        }

        foreach ($requiredSteps as $requiredStepId) {
            $requiredStep = Step::find($requiredStepId);

            if (!$requiredStep) continue;

            $isComplete = true;

            switch ($requiredStep->step_type) {
                case 'F': // Formulario
                    $form = \App\Models\InformationForm::where('step_id', $requiredStep->id)->first();
                    $answered = $form
                        ? \App\Models\InformationFormAnswer::where('information_form_id', $form->id)
                        ->where('contact_id', $contactId)
                        ->exists()
                        : false;
                    $isComplete = $answered;
                    break;

                case 'CD': // Retos y entregables
                    $challenges = \App\Models\Challenge::where('step_id', $requiredStep->id)->get();
                    $allDelivered = true;
                    foreach ($challenges as $challenge) {
                        $delivered = \App\Models\ContactsChallenge::where('challenge_id', $challenge->id)
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
                        ? \App\Models\InformationFormAnswer::where('information_form_id', $canva->information_form_id)
                        ->where('contact_id', $contactId)
                        ->exists()
                        : false;
                    $isComplete = $answered;
                    break;

                case 'AL': // Agente Alquimia
                    $agent = \App\Models\ProcessAlquimiaAgent::where('step_id', $requiredStep->id)->first();
                    $answered = $agent
                        ? \App\Models\ProcessAlquimiaAgentAnswer::where('process_alquimia_agent_id', $agent->id)
                        ->where('contact_id', $contactId)
                        ->exists()
                        : false;
                    $isComplete = $answered;
                    break;

                case 'CV': // Compliance Verification (👈 opcional, para requisitos anidados)
                    $comp = \App\Models\ProcessComplianceVerification::where('step_id', $requiredStep->id)->first();
                    $answered = $comp
                        ? \App\Models\PContactComplianceVerification::where('pc_verification_id', $comp->id)
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
                $this->incompleteSteps[] = $requiredStep;
            }
        }

        return empty($this->incompleteSteps);
    }
}
