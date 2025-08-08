<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses;

use App\Models\OnlineRegistrationCategory;
use App\Models\OnlineRegistrationChannel;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationForm;
use App\Models\OrCourseWaGroup;
use App\Models\OnlineRegistrationExternalExecution;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OnlineRegistrationCoursesComponent extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $active = 1,
        $slug,
        $embebed_video,
        $logo_file,
        $online_registration_course_id;

    public $group_name, $group_description, $group_instance;

    public
        $or_category_id, $onlineRegistrationCategory;

    public $searchName;

    public $currentFile;

    public $user_created_at, $user_updated_at;


    public $formId, $form,  $onlineRegistrationCourse;

    public $channels;
    public $channel_id;
    public $selectedChannelId;
    public $channelStructure = [];
    public $structureValues = [];

    public $fullEndpointUrl; // Se mostrará en la vista


    public $selectedGroupId;
    public $groupDescription;
    public $invitationNumbers;
    public $updateInstance, $groupParticipants, $missingParticipants;

    public function mount($id)
    {
        $this->or_category_id = $id;
        $this->onlineRegistrationCategory = OnlineRegistrationCategory::find($this->or_category_id);
        $this->channels = OnlineRegistrationChannel::where('online_registration_id', $this->onlineRegistrationCategory->online_registration_id)->get();


        //traer todos los canales para elegir el canal de creacion de grupos de whatsapp


    }

    public function render()
    {
        $onlineRegistrationCourses = OnlineRegistrationCourse::with('waGroup')
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->where('or_category_id', '=', $this->or_category_id)
            ->paginate(6);

        $firstItem = $onlineRegistrationCourses->firstItem();
        $lastItem = $onlineRegistrationCourses->lastItem();


        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$onlineRegistrationCourses->total()} registros";

        return view('livewire.admin.online-registration-courses.online-registration-courses-component', [
            'onlineRegistrationCourses' => $onlineRegistrationCourses,
            'paginationText' => $paginationText,
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('online_registrations_courses')->where(function ($query) {
                    return $query->where('or_category_id', $this->or_category_id);
                })
            ],
            'description' => 'required',
            'active' => 'required',
            'embebed_video' => 'nullable',
            'logo_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:51200',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripcion',
            'active' => 'activo',
            'embebed_video' => 'video embebido',
            'logo_file' => 'archivo de logo',
        ], [], []);

        $onlineRegistrationCourse = new OnlineRegistrationCourse();
        $onlineRegistrationCourse->name = $this->name;
        $onlineRegistrationCourse->description = $this->description;
        $onlineRegistrationCourse->active = $this->active;
        // Obtener la categoría del curso
        $category = OnlineRegistrationCategory::find($this->or_category_id);

        // Generar el slug con la categoría, el nombre del curso y "formulario-inscripcion"
        $onlineRegistrationCourse->slug = Str::slug($category->onlineRegistration->name . ' ' . $category->name . ' ' . $this->name . ' formulario-inscripcion');

        $onlineRegistrationCourse->embebed_video = $this->embebed_video;
        $onlineRegistrationCourse->or_category_id = $this->or_category_id;

        /* if ($this->logo_file) {
            $originalFileName = $this->logo_file->getClientOriginalName();
            $filePath = $this->logo_file->storeAs('public/files', $originalFileName);
            $onlineRegistrationCourse->logo_file = Storage::url($filePath);
        } */

        /*  if ($this->logo_file) {
            $originalFileName = $this->logo_file->getClientOriginalName();
            $uniqueName = Str::uuid() . '_' . $originalFileName;
            $filePath = $this->logo_file->storeAs('files', $uniqueName);

            // Aquí guardamos SOLO el path relativo
            $onlineRegistrationCourse->logo_file = $filePath;
        } */
        if ($this->logo_file) {
            // Elimina el archivo actual si existe
            if ($this->currentFile && Storage::disk('public')->exists($this->currentFile)) {
                Storage::disk('public')->delete($this->currentFile);
            }

            $originalFileName = $this->logo_file->getClientOriginalName();
            $uniqueName = Str::uuid() . '_' . $originalFileName;

            // Almacenar el archivo en el disco 'public'
            $filePath = $this->logo_file->storeAs('files', $uniqueName, 'public');

            // Guardar SOLO el path relativo
            $onlineRegistrationCourse->logo_file = $filePath;
        }

        $onlineRegistrationCourse->save();

        $form =  new OnlineRegistrationForm();
        $form->name = $onlineRegistrationCourse->name;
        $form->description = $onlineRegistrationCourse->description;
        $form->online_registration_course_id = $onlineRegistrationCourse->id;
        $form->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Curso con formulario de control de registro creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->online_registration_course_id = $id;
        $onlineRegistrationCourse = OnlineRegistrationCourse::find($id);

        $this->name = $onlineRegistrationCourse->name;
        $this->description = $onlineRegistrationCourse->description;
        $this->embebed_video = $onlineRegistrationCourse->embebed_video;
        $this->active = $onlineRegistrationCourse->active;
        $this->or_category_id = $onlineRegistrationCourse->or_category_id;
        $this->currentFile = $onlineRegistrationCourse->logo_file; // Archivo actual
        $this->logo_file = null; // Reseteamos el archivo en caso de que no se suba uno nuevo

    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('online_registrations_courses')
                    ->where(function ($query) {
                        return $query->where('or_category_id', $this->or_category_id);
                    })
                    ->ignore($this->online_registration_course_id),
            ],
            'description' => 'required',
            'active' => 'required',
            'embebed_video' => 'nullable',
            'logo_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:51200',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'active' => 'activo',
            'embebed_video' => 'video embebido',
            'logo_file' => 'archivo de logo',
        ]);

        $onlineRegistrationCourse = OnlineRegistrationCourse::find($this->online_registration_course_id);
        $onlineRegistrationCourse->name = $this->name;
        $onlineRegistrationCourse->description = $this->description;
        $onlineRegistrationCourse->active = $this->active;
        $onlineRegistrationCourse->embebed_video = $this->embebed_video;
        $onlineRegistrationCourse->or_category_id = $this->or_category_id;

        // Obtener la categoría actualizada
        $category = OnlineRegistrationCategory::find($this->or_category_id);

        // Generar el slug con la categoría, el nombre del curso y "formulario-inscripcion"
        $onlineRegistrationCourse->slug = Str::slug($category->name . ' ' . $this->name . ' formulario-inscripcion');

        /*  if ($this->logo_file) {
            $originalFileName = $this->logo_file->getClientOriginalName();
            $filePath = $this->logo_file->storeAs('public/files', $originalFileName);
            $onlineRegistrationCourse->logo_file = Storage::url($filePath);
        } elseif ($this->currentFile === null) {
            $onlineRegistrationCourse->logo_file = null;
        }
 */

        if ($this->logo_file) {
            // Elimina el archivo actual si existe
            if ($this->currentFile && Storage::disk('public')->exists($this->currentFile)) {
                Storage::disk('public')->delete($this->currentFile);
            }

            $originalFileName = $this->logo_file->getClientOriginalName();
            $uniqueName = Str::uuid() . '_' . $originalFileName;

            // Almacenar el archivo en el disco 'public'
            $filePath = $this->logo_file->storeAs('files', $uniqueName, 'public');

            // Guardar SOLO el path relativo
            $onlineRegistrationCourse->logo_file = $filePath;
        }


        $onlineRegistrationCourse->update();

        // Actualizar el formulario vinculado
        $form = OnlineRegistrationForm::where('online_registration_course_id', $onlineRegistrationCourse->id)->first();
        if ($form) {
            $form->name = $onlineRegistrationCourse->name;
            $form->description = $onlineRegistrationCourse->description;
            $form->update();
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Curso con formulario de control de registro actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->online_registration_course_id = $id;
    }

    public function destroy()
    {
        $onlineRegistrationCourse = OnlineRegistrationCourse::with('form')->find($this->online_registration_course_id);

        if ($onlineRegistrationCourse->logo_file) {
            // Eliminar el archivo asociado en el disco 'public'
            $filePath = $onlineRegistrationCourse->logo_file;

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Eliminar el registro del curso
        $onlineRegistrationCourse->delete();

        // Emitir alerta de éxito
        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Curso con formulario de control de registro eliminado correctamente',
        ]);

        // Cancelar cualquier acción activa
        $this->cancel();
    }



    public function removeFile()
    {
        if ($this->currentFile) {
            // Convertir la URL en una ruta relativa válida
            $filePath = str_replace('/storage/', 'public/', $this->currentFile);

            // Verificar si el archivo existe antes de eliminarlo
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Limpiar la variable de la imagen
            $this->currentFile = null;
            $this->logo_file = null;
        }
    }


    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->embebed_video = '';
        $this->online_registration_course_id = '';
        $this->active = 1;
        $this->currentFile = null;
        $this->logo_file = null;
        $this->slug = '';
        $this->user_created_at = '';
        $this->user_updated_at = '';
        $this->slug = '';
        $this->form = '';
        $this->formId = '';
        $this->onlineRegistrationCourse = '';
        $this->group_name = '';
        $this->group_description = '';
        $this->group_instance = '';
    }


    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function getSlug($id)
    {
        $onlineRegistrationCourse = OnlineRegistrationCourse::find($id);
        $slug = $onlineRegistrationCourse->slug;
        $this->slug = url('public-registration-form/' . $slug);
    }

    public function preview($id)
    {
        $this->onlineRegistrationCourse = OnlineRegistrationCourse::find($id);
        if ($this->onlineRegistrationCourse) {
            $this->form = OnlineRegistrationForm::where('online_registration_course_id', $this->onlineRegistrationCourse->id)->first();
            $this->formId = $this->form ? $this->form->id : null;
        } else {
            $this->form = null;
            $this->formId = null;
        }
    }

    public function show($id)
    {
        $this->online_registration_course_id = $id;

        $onlineRegistrationCourse = OnlineRegistrationCourse::find($id);
        $this->name = $onlineRegistrationCourse->name;
        $this->description = $onlineRegistrationCourse->description;
        $this->active = $onlineRegistrationCourse->active;
        $this->slug = $onlineRegistrationCourse->slug;
        $this->embebed_video = $onlineRegistrationCourse->embebed_video;
        $this->logo_file = $onlineRegistrationCourse->logo_file;
        $userCreate = User::find($onlineRegistrationCourse->user_created_at);
        $this->user_created_at = $userCreate->name;
        $userUpdate = User::find($onlineRegistrationCourse->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function hydrate()
    {
        $this->emit('select2');
    }


    public function preparateGroup($id)
    {
        $this->online_registration_course_id = $id;
    }

    public function updatedSelectedChannelId($channelId)
    {
        $channel = OnlineRegistrationChannel::find($channelId);

        if ($channel) {
            $this->channelStructure = json_decode($channel->structure, true); // convertir JSON en array asociativo
            $this->channel_id = $channel->id;
            $this->fillParticipantsFromContacts(); // solo si hay campo de participants
        }
        $this->updateFullEndpointUrl();
    }

    public function updatedGroupInstance()
    {
        $this->updateFullEndpointUrl();
    }

    public function updateFullEndpointUrl()
    {
        $channel = OnlineRegistrationChannel::find($this->selectedChannelId);
        if ($channel && $this->group_instance) {
            $baseUrl = rtrim($channel->url, '/');
            $path = ltrim($this->group_instance, '/');
            $this->fullEndpointUrl = "{$baseUrl}/{$path}";
        } else {
            $this->fullEndpointUrl = null;
        }
    }

    public function fillParticipantsFromContacts()
    {
        $contactCourses = OnlineRegistrationContactCourse::with('contact')
            ->where('or_course_id', $this->online_registration_course_id)
            ->get();

        $participants = [];

        foreach ($contactCourses as $courseContact) {
            $contact = $courseContact->contact;

            if ($contact) {
                $number = $contact->whatsapp ?: $contact->phone;

                if ($number) {
                    $cleanedNumber = preg_replace('/\D/', '', $number);

                    if (!str_starts_with($cleanedNumber, '57')) {
                        $cleanedNumber = '57' . $cleanedNumber;
                    }

                    if (strlen($cleanedNumber) >= 12) {
                        $participants[] = $cleanedNumber;
                    }
                }
            }
        }

        // Asignar al JSON sólo si el campo existe
        if (isset($this->channelStructure['body']['participants'])) {
            $this->channelStructure['body']['participants'] = $participants;
        }
    }


    protected function initializeStructureValues($structure)
    {
        $values = [];

        foreach ($structure as $section => $fields) {
            foreach ($fields as $key => $value) {
                $values[$section][$key] = is_array($value) ? [] : '';
            }
        }

        return $values;
    }

    public function createWaGroup()
    {
        $this->validate([
            'selectedChannelId' => 'required|exists:online_registrations_channels,id',
            'group_instance' => 'required',
            'structureValues.body.subject' => 'required|string',
            'structureValues.body.description' => 'required|string',
        ], [], [
            'structureValues.body.subject' => 'asunto del grupo',
            'structureValues.body.description' => 'descripción del grupo',
        ]);



        // Obtener canal seleccionado
        $channel = OnlineRegistrationChannel::find($this->selectedChannelId);
        if (!$channel) {
            $this->addError('channel_id', 'El canal seleccionado no existe.');
            return;
        }

        $baseUrl = rtrim($channel->url, '/'); // Asegura que no tenga slash final
        $path = ltrim($this->group_instance, '/'); // Asegura que no tenga slash inicial
        $endpoint = "{$baseUrl}/{$path}";

        // Obtener contactos del curso
        $contactCourses = OnlineRegistrationContactCourse::with('contact')
            ->where('or_course_id', $this->online_registration_course_id)
            ->get();

        $participants = [];

        foreach ($contactCourses as $courseContact) {
            $contact = $courseContact->contact;

            if ($contact) {
                $number = trim($contact->whatsapp) !== '' ? $contact->whatsapp : $contact->phone;
                if ($number) {
                    $cleanedNumber = preg_replace('/\D/', '', $number);

                    if (!str_starts_with($cleanedNumber, '57')) {
                        $cleanedNumber = '57' . $cleanedNumber;
                    }

                    if (strlen($cleanedNumber) >= 12) {
                        $participants[] = (string) $cleanedNumber;
                    }
                }
            }
        }

        if (empty($participants)) {


            dd('No hay participantes válidos', [
                'contactos' => $contactCourses->map(fn($c) => [
                    'nombre' => $c->contact->name ?? null,
                    'whatsapp' => $c->contact->whatsapp ?? null,
                    'phone' => $c->contact->phone ?? null,
                ])->toArray()
            ]);

            session()->flash('error', 'No hay participantes con número válido para este curso.');
            return;
        }


        // Obtener API Key desde la estructura del canal
        $structure = json_decode($channel->structure, true);
        $apiKey = data_get($structure, 'headers.apikey');
        if (!$apiKey) {
            $this->addError('apikey', 'El canal no tiene configurada la clave API en su estructura, por favor modifica el JSON en el canal.');
            return;
        }



        $subject = data_get($this->structureValues, 'body.subject');
        $description = data_get($this->structureValues, 'body.description');


        $payload = [
            'subject' => $subject,
            'description' => $description,
            'participants' => $participants,
        ];

        $headers = [
            'Accept' => '*/*',
            'User-Agent' => 'LaravelApp/1.0',
            'Content-Type' => 'application/json',
            'apikey' => $apiKey,
        ];


        $response = Http::withHeaders($headers)
            ->timeout(20)
            ->post($endpoint, $payload);


        OnlineRegistrationExternalExecution::create([
            'method' => 'POST',
            'url' => $endpoint,
            'message' => $response->successful() ? 'Grupo creado exitosamente' : 'Fallo al crear grupo',
            'status' => $response->status(),
            'request' => json_encode([
                'headers' => $headers,
                'body' => $payload,
                'response' => $response->json(),
            ]),
            'type' => 'whatsapp_group_creation',
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $groupJid = $responseData['id'] ?? null;

            // Guardar en base de datos
            $orWaCourse = new OrCourseWaGroup();
            $orWaCourse->name = $subject;
            $orWaCourse->description = $description;
            $orWaCourse->instance = $this->group_instance;
            $orWaCourse->or_course_id = $this->online_registration_course_id;
            $orWaCourse->group_id = $groupJid;
            $orWaCourse->save();

            session()->flash('success', 'Grupo de WhatsApp creado correctamente.');
        } else {
            $this->addError('api', 'Error al crear el grupo en la API: ' . $response->body());
        }
        $this->cancel();
    }

    public function updateWaGroup()
    {

        $this->validate([
            'selectedChannelId' => 'required|exists:online_registrations_channels,id',
            'group_instance' => 'required',
            'structureValues.body.subject' => 'required|string',
            'structureValues.body.description' => 'required|string',
        ], [], [
            'structureValues.body.subject' => 'asunto del grupo',
            'structureValues.body.description' => 'descripción del grupo',
        ]);


        $group = OrCourseWaGroup::findOrFail($this->selectedGroupId);
        $channel = OnlineRegistrationChannel::where('type', 'whatsapp')->first(); // o como lo relaciones

        $groupJid = $group->group_id;
        $description = $this->groupDescription;
        $numbers = array_map('trim', explode(',', $this->invitationNumbers));
        $apiKey = $channel->structure['apikey'] ?? null;
        $instance = $this->updateInstance;

        $endpoint = "https://apiwa1.dynix.io/group/sendInvite/{$instance}";

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey' => $apiKey,
                ],
                'json' => [
                    'groupJid' => $groupJid,
                    'description' => $description,
                    'numbers' => $numbers,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                session()->flash('message', 'Grupo actualizado exitosamente');
            } else {
                session()->flash('error', 'Error actualizando grupo');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error de conexión: ' . $e->getMessage());
        }
    }


    // public function openUpdateGroupModal($id)
    // {
    //     $group = OrCourseWaGroup::where('or_course_id', $id)->first();
    //     $this->selectedGroupId = $id;

    //     $response = Http::withHeaders([
    //         'Accept' => '*/*',
    //         'User-Agent' => 'LaravelApp/1.0',
    //         'Content-Type' => 'application/json',
    //         'apikey' => env('WA_API_KEY'),
    //     ])
    //         ->timeout(20)
    //         ->get("https://apiwa1.dynix.io/group/findGroupInfos/parquesoftnarino", [
    //             'groupJid' => $group->group_id
    //         ]);

    //     // Acceder al contenido de la respuesta como array
    //     $data = $response->json();

    //     // Obtener los participants
    //     $participants = $data['participants'] ?? [];

    //     // (Opcional) Guardar en una propiedad pública si estás en Livewire
    //     $this->groupParticipants = $participants;

    //     // Convertir a formato limpio sin @s.whatsapp.net
    //     $groupNumbers = collect($this->groupParticipants)
    //         ->pluck('id')
    //         ->map(function ($id) {
    //             return str_replace('@s.whatsapp.net', '', $id);
    //         })
    //         ->toArray();

    //     // 2. Obtener participantes del curso (registrados en tu sistema)
    //     $contactCourses = OnlineRegistrationContactCourse::with('contact')
    //         ->where('or_course_id', $id)
    //         ->get();



    //     foreach ($contactCourses as $courseContact) {
    //         $contact = $courseContact->contact;

    //         if ($contact) {
    //             $number = trim($contact->whatsapp) !== '' ? $contact->whatsapp : $contact->phone;
    //             if ($number) {
    //                 $cleanedNumber = preg_replace('/\D/', '', $number);

    //                 if (!str_starts_with($cleanedNumber, '57')) {
    //                     $cleanedNumber = '57' . $cleanedNumber;
    //                 }

    //                 if (strlen($cleanedNumber) >= 12) {
    //                     $courseNumbers[] = preg_replace('/\D/', '', $cleanedNumber);  // Solo los números
    //                 }
    //             }
    //         }
    //     }

    //     // 3. Comparar: quiénes están en el curso pero no en el grupo de WhatsApp
    //     $missingInGroup = array_diff($courseNumbers, $groupNumbers);
    //     $missingInGroup = array_filter($missingInGroup, function ($value) {
    //         return !empty($value);
    //     });
    //     // dd($missingInGroup);


    //     // 4. Si no hay faltantes, no hacer nada
    //     if (empty($missingInGroup)) {
    //         $this->emit('alert', ['type' => 'error', 'message' => 'Todos los participantes ya están en el grupo de WhatsApp.']);
    //         return;
    //     }

    //     $or_course = OnlineRegistrationCourse::find($id);
    //     $groupJid = $group->group_id;

    //     // 5. Intentar agregar directamente al grupo
    //     $endpoint = "https://apiwa1.dynix.io/group/updateParticipant/parquesoftnarino?groupJid={$groupJid}";
    //     $participants = [
    //         '573127725080', // Agregar manualmente el primer número
    //         '573183578094', // Agregar manualmente el segundo número
    //     ];

    //     $payload = [
    //         'action' => 'add',
    //         'participants' => array_values($missingInGroup), // Asegúrate de que no haya coma extra al final
    //     ];

    //     $addResponse = Http::withHeaders([
    //         'Accept' => '*/*',
    //         'User-Agent' => 'Thunder Client',
    //         'Content-Type' => 'application/json',
    //         'apikey' => env('WA_API_KEY'),
    //     ])
    //         ->timeout(20)
    //         ->post($endpoint, $payload);

    //     dd($addResponse->json(), $payload, $missingInGroup);

    //     // 6. Si la API responde que algunos no pudieron ser añadidos, enviarles invitación
    //     // Puedes validar aquí con base en el contenido real del $addResponse
    //     $inviteResponse = Http::withHeaders([
    //         'Accept' => '*/*',
    //         'User-Agent' => 'LaravelApp/1.0',
    //         'Content-Type' => 'application/json',
    //         'apikey' => env('WA_API_KEY'),
    //     ])
    //         ->timeout(20)
    //         ->post("https://apiwa1.dynix.io/group/sendInvite/parquesoftnarino", [
    //             'groupJid' => $group->group_id,
    //             'description' => "¡Hola! Aún no estás en el grupo del curso: \"{$or_course->name}\", por favor acepta la invitación.",
    //             'numbers' => array_values($missingInGroup),
    //         ]);
    //     session()->flash('message', 'Se han procesado los participantes faltantes.');
    // }

    public function openUpdateGroupModal($id)
    {
        $group = OrCourseWaGroup::where('or_course_id', $id)->first();
        $this->selectedGroupId = $id;

        $response = Http::withHeaders([
            'Accept' => '*/*',
            'User-Agent' => 'LaravelApp/1.0',
            'Content-Type' => 'application/json',
            'apikey' => env('WA_API_KEY'),
        ])
            ->timeout(20)
            ->get("https://apiwa1.dynix.io/group/findGroupInfos/parquesoftnarino", [
                'groupJid' => $group->group_id
            ]);

        // Acceder al contenido de la respuesta como array
        $data = $response->json();

        // Obtener los participantes del grupo
        $participants = $data['participants'] ?? [];

        // Convertir los números a formato limpio sin @s.whatsapp.net
        $groupNumbers = collect($participants)
            ->pluck('id')
            ->map(function ($id) {
                return str_replace('@s.whatsapp.net', '', $id);
            })
            ->toArray();

        // Obtener los participantes del curso (registrados en tu sistema)
        $contactCourses = OnlineRegistrationContactCourse::with('contact')
            ->where('or_course_id', $id)
            ->get();

        $courseNumbers = [];

        foreach ($contactCourses as $courseContact) {
            $contact = $courseContact->contact;

            if ($contact) {
                $number = trim($contact->whatsapp) !== '' ? $contact->whatsapp : $contact->phone;
                if ($number) {
                    $cleanedNumber = preg_replace('/\D/', '', $number);

                    if (!str_starts_with($cleanedNumber, '57')) {
                        $cleanedNumber = '57' . $cleanedNumber;
                    }

                    if (strlen($cleanedNumber) >= 12) {
                        $courseNumbers[] = preg_replace('/\D/', '', $cleanedNumber); // Solo números
                    }
                }
            }
        }

        // Comparar: quiénes están en el curso pero no en el grupo de WhatsApp
        $missingInGroup = array_diff($courseNumbers, $groupNumbers);

        // Si no hay faltantes, no hacer nada
        if (empty($missingInGroup)) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Todos los participantes ya están en el grupo de WhatsApp.']);
            return;
        }

        // Agregar participantes faltantes
        $or_course = OnlineRegistrationCourse::find($id);
        $groupJid = $group->group_id;

        // Endpoint para agregar participantes
        $endpoint = "https://apiwa1.dynix.io/group/updateParticipant/parquesoftnarino?groupJid={$groupJid}";

        // Preparar los números de participantes en formato adecuado
        $participants = array_values($missingInGroup); // Asegúrate de que no haya coma extra al final

        // Formato de payload correcto
        $payload = [
            'action' => 'add',
            'participants' => $participants, // Lista de números
        ];

        // Enviar la solicitud para agregar los participantes al grupo
        $addResponse = Http::withHeaders([
            'Accept' => '*/*',
            'User-Agent' => 'Thunder Client',
            'Content-Type' => 'application/json',
            'apikey' => env('WA_API_KEY'),
        ])
            ->timeout(20)
            ->post($endpoint, $payload);

        // Si la API responde que algunos no pudieron ser añadidos, enviarles invitación
        $inviteResponse = Http::withHeaders([
            'Accept' => '*/*',
            'User-Agent' => 'LaravelApp/1.0',
            'Content-Type' => 'application/json',
            'apikey' => env('WA_API_KEY'),
        ])
            ->timeout(20)
            ->post("https://apiwa1.dynix.io/group/sendInvite/parquesoftnarino", [
                'groupJid' => $group->group_id,  // ID del grupo de WhatsApp
                'description' => "¡Hola! Aún no estás en el grupo del curso: \"{$or_course->name}\", por favor acepta la invitación.",  // Descripción del mensaje
                'numbers' => array_values($missingInGroup),  // Lista de números de teléfono de los participantes que no se pudieron agregar
            ]);
        $this->emit('alert', ['type' => 'success', 'message' => 'Todos los participantes ya están en el grupo de WhatsApp.']);

        // Depurar la respuesta directamente con dd()
        dd($inviteResponse->json(), $missingInGroup);
    }



    public function prepareGroupInvite($id)
    {
        $group = OrCourseWaGroup::findOrFail($id);
        $this->selectedGroupId = $id;
        $this->groupDescription = $group->description;
        $this->invitationNumbers = ''; // vacía para que los ingresen manualmente
    }
}
