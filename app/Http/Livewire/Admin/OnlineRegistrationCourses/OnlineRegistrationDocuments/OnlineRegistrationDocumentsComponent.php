<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationDocuments;

use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationDocument;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OnlineRegistrationDocumentsComponent extends Component
{

    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $or_course_id, $onlineRegistrationCourse;

    public $searchName;

    public $name;
    public $url;
    public $type;
    public $required;
    public $video_embebed;
    public $document_id;
    public $currentFile;


    public $file;

    public $user_created_at,  $user_updated_at;

    public function mount($id)
    {
        $this->or_course_id = $id;
        $this->onlineRegistrationCourse = OnlineRegistrationCourse::find($this->or_course_id);
    }

    public function render()
    {

        $query = OnlineRegistrationDocument::with('onlineRegistrationCourse')->where('or_course_id', $this->or_course_id);

        if ($this->searchName) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%');
            });
        }

        $documents = $query->paginate(25);

        return view('livewire.admin.online-registration-courses.online-registration-documents.online-registration-documents-component', [
            'documents' => $documents,
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'required' => 'required|boolean',
            'file' => 'required|file|mimes:doc,docx,jpg,jpeg,png,gif,pdf',
            'video_embebed' => 'nullable|string',
        ], [], [
            'name' => 'nombre',
            'type' => 'tipo',
            'required' => 'requerido',
            'file' => 'archivo',
            'video_embebed' => 'video embebido',
        ]);

        if ($this->type === 'O') {
            $this->required = 0;
        }
        $document = new OnlineRegistrationDocument();
        $document->name = $this->name;
        $document->type = $this->type;
        $document->required = $this->required;
        $document->or_course_id = $this->or_course_id;

        if ($this->file) {
            $originalFileName = $this->file->getClientOriginalName();
            $uniqueName = Str::uuid() . '_' . $originalFileName;
            $filePath = $this->file->storeAs('or-documents-files/courses-documents', $uniqueName);

            // Aquí guardamos SOLO el path relativo
            $document->url = $filePath;
        }

        $document->video_embebed = $this->video_embebed;

        $document->save();

        $this->reset([
            'name',
            'type',
            'required',
            'file',
            'video_embebed'
        ]);

        $this->emit('alert', ['type' => 'success', 'message' => 'Documento creado exitosamente.']);

        $this->cancel();
    }

    public function edit($id)
    {
        $document = OnlineRegistrationDocument::findOrFail($id);

        $this->document_id = $document->id;
        $this->name = $document->name;
        $this->type = $document->type;
        $this->required = $document->required;
        $this->video_embebed = $document->video_embebed;
        $this->currentFile = $document->url; // ruta actual del archivo
        $this->file = null;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'required' => 'required|boolean',
            'file' => 'nullable|file|mimes:doc,docx,jpg,jpeg,png,gif,pdf',
            'video_embebed' => 'nullable|string',
        ], [], [
            'name' => 'nombre',
            'type' => 'tipo',
            'required' => 'requerido',
            'file' => 'archivo',
            'video_embebed' => 'video embebido',
        ]);

        if ($this->type === 'O') {
            $this->required = 0;
        }

        $document = OnlineRegistrationDocument::findOrFail($this->document_id);

        $document->name = $this->name;
        $document->type = $this->type;
        $document->required = $this->required;
        $document->video_embebed = $this->video_embebed;

        if ($this->file) {
            // Elimina el archivo actual si existe
            if ($this->currentFile && Storage::exists($this->currentFile)) {
                Storage::delete($this->currentFile);
            }

            // Sube el nuevo archivo
            $originalFileName = $this->file->getClientOriginalName();
            $uniqueName = Str::uuid() . '_' . $originalFileName;
            $filePath = $this->file->storeAs('or-documents-files/courses-documents', $uniqueName);

            // Actualiza la ruta del archivo en el documento
            $document->url = $filePath;
        }

        $document->save();

        // Restablece los valores del formulario
        $this->reset(['name', 'type', 'required', 'file', 'video_embebed', 'document_id', 'currentFile']);
        $this->emit('alert', ['type' => 'success', 'message' => 'Documento actualizado exitosamente.']);

        $this->cancel();
    }




    public function delete($id)
    {
        $this->document_id = $id;
    }

    public function destroy()
    {
        $document = OnlineRegistrationDocument::find($this->document_id);

        if (!$document) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Documento no encontrado.']);
            return;
        }

        // Eliminar archivo del sistema si existe
        if ($document->url) {
            $filePath = $document->url; // Ya guardamos solo el path relativo
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        $document->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Documento eliminado correctamente.']);
        $this->cancel();
    }




    public function resetInputFields()
    {
        $this->name = '';
        $this->type = '';
        $this->url = '';
        $this->required = '';
        $this->video_embebed = '';
        $this->file = null;
        $this->user_created_at = '';
        $this->user_updated_at = '';
        $this->document_id = '';
    }


    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function updatedType($value)
    {
        if ($value === 'O') {
            $this->required = 0;
        }
    }

    public function downloadDocument($url_file)
    {
            $filePath = storage_path('app/' . $url_file);
            return response()->download($filePath);

    }
}
