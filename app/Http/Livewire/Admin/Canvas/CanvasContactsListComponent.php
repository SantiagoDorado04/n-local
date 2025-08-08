<?php

namespace App\Http\Livewire\Admin\Canvas;

use App\Canva;
use App\Contact;
use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InformationForm;
use Illuminate\Support\Facades\DB;
use App\Models\InformationFormAnswer;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Exports\ContactsCanvasListExport;

class CanvasContactsListComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $formId;
    public $contactId;
    public $step, $canva;
    public $stepId;
    public $searchName;

    public function mount($id)
    {
        $this->formId = $id;
        $this->canva = Canva::where('information_form_id', $id)->first();

        if ($this->canva) {
            // Accede a la propiedad step_id de la instancia del modelo
            $this->stepId = $this->canva->step_id;

            // Asegúrate de cargar la instancia del modelo Step
            $this->step = Step::find($this->stepId);
        } else {
            // Maneja el caso donde no se encuentra el registro
            $this->stepId = null;
            $this->step = null;
        }
    }

    public function render()
    {
        $form = InformationForm::findOrFail($this->formId);

        $query = DB::table('information_forms_answers as a')
            ->join('contacts as contacts', 'a.contact_id', '=', 'contacts.id')
            ->select('contacts.id as contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'contacts.whatsapp', 'contacts.contact_person_name')
            ->where('a.information_form_id', $this->formId)
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

        return view('livewire.admin.canvas.canvas-contacts-list-component', [
            'form' => $form,
            'contacts' => $contacts,
        ]);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }


    public function downloadTemplate($contactId)
    {
        $contactId = $contactId ?: $this->contactId;

        if (!$contactId) {
            session()->flash('error', 'No se ha seleccionado ningún contacto.');
            return;
        }

        $canva = Canva::where('information_form_id', $this->formId)->first();

        if ($canva && $canva->url_file) {
            $filePath = storage_path('app/' . $canva->url_file);
            $templateProcessor = new TemplateProcessor($filePath);

            $form = InformationForm::find($this->formId);
            $questions = $form->questions;

            foreach ($questions as $question) {
                $variableName = $this->convertToVariable($question->text);
                $answer = InformationFormAnswer::where('contact_id', $contactId)
                    ->where('information_form_id', $form->id)
                    ->where('question_id', $question->id)
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
                $canva->step->name,
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

        $form = InformationForm::findOrFail($this->formId);
        $canva = Canva::where('information_form_id', $this->formId)->first();

        $contacts = DB::table('information_forms_answers as a')
            ->join('contacts as contacts', 'a.contact_id', '=', 'contacts.id')
            ->select('contacts.id as contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'contacts.whatsapp', 'contacts.contact_person_name')
            ->where('a.information_form_id', $this->formId)
            ->groupBy('a.contact_id', 'contacts.nit', 'contacts.name', 'contacts.phone', 'contacts.email', 'a.created_at')
            ->having(DB::raw('COUNT(a.id)'), '>', 1);

        $formName = $canva->step->name;

        $fileName = 'listado_entregas_' . $formName . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return (new ContactsCanvasListExport($form, $contacts))
            ->download($fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}
