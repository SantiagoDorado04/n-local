<?php

namespace App\Http\Livewire\Admin\ProcessComplianceVerification;

use App\Models\ContactsStage;
use App\Models\PComplianceVerificationAnswer;
use App\Models\PContactComplianceVerification;
use App\Models\ProcessComplianceVerification;
use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;

class ProcessComplianceVerificationAnswersComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $deleteContactId;
    public $contactId;

    public $questionId,  $text,
        $type,
        $position;

    public $answers = [];
    public $contact_compliance_id;
    public $compliance_id;

    public $searchName;
    public $idFeedback;

    public $step_id;
    public $step;
    public $sortDirection = 'asc';

    public $compliance;
    public $preview;
    public $info;
    public $questionsInfo;
    public $answerInfo;
    public $sortField = 'id';

    public function mount($id)
    {
        $this->info = collect();
        $this->step = Step::find($id);
        $this->compliance = ProcessComplianceVerification::where('step_id', $id)->first();
        $this->compliance_id = $this->compliance->id;
        $this->step_id = $this->step->id;
    }

    public function render()
    {
        // Construir la consulta base
        $query = ContactsStage::where('stage_id', $this->step->stage_id)
            ->with(['contact' => function ($q) {
                $q->select('id', 'nit', 'name', 'email', 'phone', 'whatsapp', 'contact_person_name');
            }])
            ->select('contact_id')
            ->distinct();


        // Filtro por búsqueda de nombre o NIT
        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }

        // Paginación
        $registers = $query->paginate(20);

        // Generar texto de paginación
        $firstItem = $registers->firstItem();
        $lastItem = $registers->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$registers->total()} registros";
        return view('livewire..admin.process-compliance-verification.process-compliance-verification-answers-component', [
            'registers' => $registers,
            'paginationText' => $paginationText,
            'compliance' => $this->compliance,
        ]);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function preview($contactId)
    {
        $this->contactId = $contactId;

        $this->preview = PComplianceVerificationAnswer::where('pc_verification_id', $this->compliance->id)
            ->where('contact_id', $this->contactId)
            ->with('question')
            ->get()
            ->map(function ($item) {
                $item->answer_text = $item->answer ?? '';
                return $item;
            });
    }

    public function delete($contactId)
    {
        $this->deleteContactId = $contactId;
    }

    public function destroy()
    {
        if (!$this->deleteContactId || !$this->test) {
            return;
        }

        PComplianceVerificationAnswer::where('contact_id', $this->deleteContactId)
            ->where('pc_verification_id', $this->compliance->id)
            ->delete();

        // 2. Eliminar registro de ProcessContactTest
        PContactComplianceVerification::where('contact_id', $this->deleteContactId)
            ->where('pc_verification_id', $this->compliance->id)
            ->delete();

        $this->cancel();

        // Notificar
        $this->emit('alert', ['type' => 'danger', 'message' => 'Respuestas eliminadas correctamente.']);
    }

    public function resetInputFields()
    {
        $this->answers = [];
        $this->contactId = '';
        $this->deleteContactId = null;
    }
}
