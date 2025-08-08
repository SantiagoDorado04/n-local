<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationAnswers;

use App\Contact;
use App\Jobs\NewSendEmailJob;
use App\Models\OnlineRegistrationCharacterization;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationFormAnswer;
use App\Models\OrAssignedCharacterization;
use App\Models\OrCharacterizationAnswer;
use App\Models\OrCharacterizationOption;
use App\Models\OrCharacterizationQuestion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OrCharacterizationAnswersComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nit,
        $name,
        $filePostulates,
        $feedback,
        $phone,
        $email,
        $whatsapp,
        $website,
        $contact_person_name,
        $contactId;

    public $questionId,  $text,
        $type,
        $position;
    public $answers = [];

    public $user_created_at, $user_updated_at;
    public $contactCourseID;
    public $characterization_id;

    public $searchName;
    public $characterization;
    public $idFeedback;

    public $or_course_id;
    public $sortDirection = 'asc';

    public $formId;
    public $form;
    public $preview;
    public $info;
    public $questionsInfo;
    public $answerInfo;
    public $sortField = 'id';

    public function mount($id)
    {
        $this->info = collect();

        $this->formId = $id;
        $this->form = OnlineRegistrationCharacterization::find($this->formId);
        $characterization = OnlineRegistrationCharacterization::find($this->formId);
        $this->characterization = OnlineRegistrationCharacterization::find($this->formId);
        $this->or_course_id = $characterization->session->or_course_id;
    }

    public function render()
    {
        $characterization = OnlineRegistrationCharacterization::find($this->formId);
        $session = OnlineRegistrationCourseSession::where('id', $characterization->session_id)->first();
        $contactCourse = OnlineRegistrationContactCourse::where('or_course_id', $session->or_course_id)->get();
        $this->contactCourseID = $contactCourse;

        $form = OnlineRegistrationCharacterization::findOrFail($this->formId);

        // Construir la consulta base
        $query = OrAssignedCharacterization::select(
            'contact_id',
            DB::raw('MAX(id) as id'),
            DB::raw('MAX(answered) as answered')
        )
            ->where('characterization_id', '=', $this->formId)
            ->groupBy('contact_id')
            ->havingRaw('COUNT(characterization_id) > 0');

        // Filtro por búsqueda de nombre o NIT
        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }

        // Ordenamiento si se requiere
        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        // Paginación
        $registers = $query->paginate(20);

        // Generar texto de paginación
        $firstItem = $registers->firstItem();
        $lastItem = $registers->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$registers->total()} registros";

        return view('livewire.admin.online-registration-characterizations.or-characterization-answers.or-characterization-answers-component', [
            'registers' => $registers,
            'paginationText' => $paginationText,
            'form' => $form,
        ]);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
    public function edit($id)
    {
        $this->contactId = $id;

        $contact = Contact::findOrFail($id);
        $this->nit = $contact->nit;
        $this->name = $contact->name;
        $this->phone = $contact->phone;
        $this->email = $contact->email;
        $this->whatsapp = $contact->whatsapp;
        $this->website = $contact->website;
        $this->contact_person_name = $contact->contact_person_name;
    }
    public function update()
    {
        $this->validate([
            'nit' => 'required|unique:contacts,nit,' . $this->contactId,
            'name' => 'required',
            'phone' => 'required|integer',
            'email' => 'required',
            'whatsapp' => 'integer|nullable',
            'website' => 'nullable',
            'contact_person_name' => 'required',
        ], [], [
            'nit' => 'NIT',
            'name' => 'nombre',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'whatsapp' => 'whatsapp',
            'website' => 'sitio web',
            'contact_person_name' => 'nombre persona de contacto',
        ]);

        $contact = Contact::findOrFail($this->contactId);
        $contact->update([
            'nit' => $this->nit,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'website' => $this->website,
            'contact_person_name' => $this->contact_person_name,
        ]);
        $user = User::findOrFail($contact->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);


        $this->emit('alert', ['type' => 'success', 'message' => 'Postulado actualizado correctamente']);
        $this->cancel();
    }
    public function feedback($id)
    {

        $contact = OnlineRegistrationContactCourse::where('contact_id', $id)->where('or_course_id', $this->or_course_id)->first();
        $this->feedback = $contact->feedback;
        $this->contactId = $contact->id;
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        $contact = OnlineRegistrationContactCourse::findOrFail($this->contactId);

        $contact->feedback =  $this->feedback;
        $contact->update();


        //Email
        $contact = Contact::find($this->contactId);
        $content = 'Hola ' . $contact->name . 'se ha registrado un feedback a la entrega del formulario.';
        NewSendEmailJob::dispatch($contact->email, 'Feedback Registro Formulario', $content);


        $this->emit('alert', ['type' => 'success', 'message' => 'Feedback agregado correctamente']);
        $this->cancel();
    }

    public function preview($characterizationId, $contactId)
    {
        $this->preview = $characterizationId;
        $this->contactId = $contactId;

        $characterization = OrAssignedCharacterization::find($characterizationId);

        if ($characterization) {
            $this->preview = OrCharacterizationAnswer::where('characterization_id', $characterization->characterization_id)
                ->where('contact_id', $this->contactId)
                ->with(['question', 'option']) // Relación con las preguntas y opciones
                ->get()
                ->map(function ($item) {
                    // Procesar las respuestas
                    if (strpos($item->answer, ',') !== false) {
                        // Si es una respuesta múltiple (separada por comas)
                        $optionIds = explode(',', $item->answer);
                        $optionTexts = OrCharacterizationOption::whereIn('id', $optionIds)->pluck('text')->toArray();
                        $item->answer_text = implode(', ', $optionTexts);
                    } elseif ($item->option) {
                        // Si es una respuesta simple con opción
                        $item->answer_text = $item->option->text;
                    } else {
                        // Si es una respuesta de texto libre
                        $item->answer_text = $item->answer;
                    }

                    return $item;
                });
        } else {
            $this->preview = collect();
        }
    }



    public function delete($id)
    {
        $this->contactId = $id;
    }

    public function destroy()
    {
        foreach ($this->form->questions as $questions) {
            $question = OrCharacterizationAnswer::where('contact_id', $this->contactId)
                ->where('characterization_id', $this->formId)
                ->where('question_id', $questions->id)
                ->with('question', 'option')
                ->first();

            if ($question) {
                // Verificar si es una pregunta de tipo 'OM'
                if ($question->question->type == 'OM') {
                    // Dividir las respuestas en caso de ser opciones múltiples
                    $responses = explode(',', $question->answer); // Ejemplo: '1,2,3' -> ['1', '2', '3']

                    // Obtener todas las opciones correspondientes a las respuestas
                    $options = OrCharacterizationOption::whereIn('id', $responses)
                        ->where('conditional', true)
                        ->pluck('characterization_id'); // Extraer solo los "characterization_id"

                    // Eliminar las caracterizaciones relacionadas
                    OrAssignedCharacterization::where('contact_id', $this->contactId)
                        ->whereIn('characterization_id', $options)
                        ->delete();
                } else {
                    // Manejo de preguntas no 'OM'
                    if ($question->option && $question->option->conditional == 1) {
                        OrAssignedCharacterization::where('contact_id', $this->contactId)
                            ->where('characterization_id', $question->option->characterization_id)
                            ->delete();
                    }
                }
            }
        }

        $contact = Contact::find($this->contactId);

        if ($contact) {
            OrCharacterizationAnswer::where('contact_id', $this->contactId)
                ->where('characterization_id', $this->formId)
                ->delete();
            $this->emit('alert', ['type' => 'success', 'message' => 'Registrado y respuestas del formulario eliminados correctamente']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se pudo encontrar el registrado']);
        }
        $answered = OrAssignedCharacterization::where('contact_id', $this->contactId)
            ->where('characterization_id', $this->formId)
            ->update(['answered' => false]);

        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->answers = [];
        $this->feedback = '';
        $this->nit = '';
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->whatsapp = '';
        $this->website = '';
        $this->contact_person_name = '';
        $this->filePostulates = null;
        $this->contactId = '';
    }


    public function info($contactId)
    {
        $this->contactId = $contactId;

        $characterization = OnlineRegistrationCharacterization::find($this->formId);

        if ($characterization) {

            $this->questionsInfo = OrCharacterizationQuestion::where('characterization_id', $this->formId)
                ->with('options')
                ->get();
        } else {
            $this->questionsInfo = collect();
        }

        if ($this->questionsInfo->isNotEmpty()) {
            foreach ($this->questionsInfo as $question) {
            }
        }
    }

    public function saveResponses()
    {
        DB::beginTransaction();

        try {
            foreach ($this->answers as $questionId => $response) {
                $questionId = str_replace('question_', '', $questionId); // Extraer el ID de la pregunta

                if (is_array($response)) {
                    // Caso de opciones múltiples (OM)
                    $response = array_filter($response); // Eliminar valores vacíos
                    $responseString = implode(',', $response); // Combinar opciones seleccionadas
                    $this->saveAnswerAndCheckCondition($questionId, $responseString, true); // True para múltiples
                } else {
                    // Caso de opción simple (OS) o texto libre
                    $this->saveAnswerAndCheckCondition($questionId, $response, false); // False para simple
                }
            }

            // Actualizar el campo 'answered' en or_assigned_characterizations
            $assignedCharacterization = OrAssignedCharacterization::where('characterization_id', $this->formId)
                ->where('contact_id', $this->contactId)
                ->first();

            if ($assignedCharacterization) {
                $assignedCharacterization->answered = true;
                $assignedCharacterization->save();
            }

            DB::commit();

            $this->dispatchBrowserEvent('responseSaved', ['message' => 'Respuestas guardadas correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchBrowserEvent('responseError', ['message' => 'Hubo un error al guardar las respuestas.']);
        }

        $this->cancel();
    }


    protected function saveAnswerAndCheckCondition($questionId, $response, $isMultiple)
    {
        // Guardar la respuesta
        OrCharacterizationAnswer::create([
            'characterization_id' => $this->formId,
            'question_id' => $questionId,
            'answer' => $response,
            'contact_id' => $this->contactId,
        ]);

        // Verificar condiciones en opciones
        $optionIds = $isMultiple ? explode(',', $response) : [$response];

        foreach ($optionIds as $optionId) {
            $conditionalOption = OrCharacterizationOption::where('question_id', $questionId)
                ->where('id', $optionId)
                ->whereNotNull('characterization_id') // Asegurar que sea condicional
                ->first();

            if ($conditionalOption) {
                // Asignar nueva caracterización al contacto
                OrAssignedCharacterization::updateOrCreate(
                    [
                        'characterization_id' => $conditionalOption->characterization_id,
                        'contact_id' => $this->contactId,
                    ],
                    ['answered' => false] // Asegurarse de que no se marque como respondido
                );
            }
        }
    }
}
