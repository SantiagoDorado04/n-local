<?php

namespace App\Http\Livewire\Admin\ProcessAlquimiaAgent;

use App\Contact;
use App\Exports\ContactsProcessAlquimiaAgentExport;
use App\Models\ProcessAlquimiaAgent;
use App\Models\ProcessAlquimiaAgentAnswer;
use App\Models\Step;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;

class ProcessAlquimiaAgentListComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $agentId;
    public $contactId;
    public $step, $agent;
    public $stepId;
    public $searchName;

    public function mount($id)
    {
        $this->agentId = $id;
        $this->agent = ProcessAlquimiaAgent::find($id);

        if ($this->agent) {
            $this->stepId = $this->agent->step_id;
            $this->step = Step::find($this->stepId);
        } else {
            $this->stepId = null;
            $this->step = null;
        }
    }

    public function render()
    {

        /*   $agent = ProcessAlquimiaAgent::findOrFail($this->agentId); */

        $query = DB::table('process_alquimia_agent_answers as a')
            ->join('contacts as contacts', 'a.contact_id', '=', 'contacts.id')
            ->select('contacts.id as contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'contacts.whatsapp', 'contacts.contact_person_name')
            ->where('a.process_alquimia_agent_id', $this->agentId)
            ->groupBy('a.contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'a.created_at')
            ->having(DB::raw('COUNT(a.id)'), '>', 1);

        if ($this->searchName) {
            $query->where(function ($q) {
                $q->where('contacts.name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('contacts.email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('contacts.nit', 'like', '%' . $this->searchName . '%');
            });
        }

        $contacts = $query->paginate(25);

        return view('livewire..admin.process-alquimia-agent.process-alquimia-agent-list-component', [
            'agent' => $this->agent,
            'contacts' => $contacts,
        ]);
    }

    public function downloadTemplate($contactId)
    {
        $contactId = $contactId ?: $this->contactId;

        if (!$contactId) {
            session()->flash('error', 'No se ha seleccionado ningún contacto.');
            return;
        }

        $agent = ProcessAlquimiaAgent::find($this->agentId);

        if ($agent && $agent->url_file) {
            $filePath = storage_path('app/' . $agent->url_file);
            $templateProcessor = new TemplateProcessor($filePath);

            $questions = $agent->questions;

            foreach ($questions as $question) {
                $variableName = $this->convertToVariable($question->text);
                $answer = ProcessAlquimiaAgentAnswer::where('contact_id', $contactId)
                    ->where('process_alquimia_agent_id', $agent->id)
                    ->where('paa_question_id', $question->id)
                    ->first();

                $answerText = $answer ? $answer->answer : '';
                $templateProcessor->setValue($variableName, $answerText);
            }

            $contact = Contact::find($contactId);
            $contactName = $contact ? $contact->name : 'desconocido';
            $contactNIT = $contact ? $contact->nit : 'desconocido';
            $fileName = sprintf(
                '%s_%s_%s_%s.docx',
                $contactNIT,
                $contactName,
                $agent->step->name,
                date('Y-m-d_H-i-s')
            );

            $newFilePath = storage_path('app/templates/' . $fileName);
            $templateProcessor->saveAs($newFilePath);

            return response()->download($newFilePath)->deleteFileAfterSend(true);
        }

        session()->flash('error', 'No se pudo encontrar la plantilla.');
    }

    private function convertToVariable($text)
    {
        $lowercaseText = strtolower($text);

        $underscoredText = str_replace(' ', '_', $lowercaseText);

        $variable = '${' . $underscoredText . '}';

        return $variable;
    }

    public function export()
    {

        $agent = ProcessAlquimiaAgent::findOrFail($this->agentId);

        $contacts = DB::table('process_alquimia_agent_answers as a')
            ->join('contacts as contacts', 'a.contact_id', '=', 'contacts.id')
            ->select('contacts.id as contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'contacts.whatsapp', 'contacts.contact_person_name')
            ->where('a.process_alquimia_agent_id', $agent->id)
            ->groupBy('a.contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'a.created_at')
            ->having(DB::raw('COUNT(a.id)'), '>', 1);

        $formName = $agent->step->name;

        $fileName = 'listado_entregas_' . $formName . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return (new ContactsProcessAlquimiaAgentExport($agent, $contacts))
            ->download($fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
