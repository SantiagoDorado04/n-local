<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses;

use App\Models\OnlineRegistrationChannel;
use App\Models\OnlineRegistrationCourse;
use App\Models\OrCourseComunication;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrCoursesComunicationComponent extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $online_registration_course_id, $form, $searchName;
    public $or_course_comunication;
    public $ChannelCourse;
    public $name, $action, $channel, $message, $channelStructure = [];
    public $user_created_at, $user_updated_at;

    public function mount($id)
    {
        $this->online_registration_course_id = $id;
        $this->form = OnlineRegistrationCourse::where('id', $this->online_registration_course_id)->firstOrFail();
        $this->ChannelCourse = OnlineRegistrationChannel::where(
            'online_registration_id',
            $this->form->onlineRegistrationCategory->onlineRegistration->id
        )->get();
    }

    public function render()
    {
        $orCourseComunication = OrCourseComunication::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('or_course_id', '=', $this->online_registration_course_id)
            ->paginate(6);

        $firstItem = $orCourseComunication->firstItem();
        $lastItem = $orCourseComunication->lastItem();


        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$orCourseComunication->total()} registros";
        return view('livewire.admin.online-registration-courses.or-courses-comunication-component', [
            'orCourseComunication' => $orCourseComunication,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->or_course_comunication = $id;

        $orComunication = OrCourseComunication::find($id);

        $this->name = $orComunication->name;
        $this->action = $orComunication->action;
        //dd($this->action);
        $this->message = $orComunication->message;
        $this->channel = $orComunication->onlineRegistrationChannel->name;
        $userCreate = User::find($orComunication->user_created_at);
        $this->user_created_at = $userCreate->name;
        $userUpdate = User::find($orComunication->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'action' => 'required|string',
            'channel' => 'required',
        ]);

        // Ya no filtramos campos vacíos. Usamos todo como viene de la estructura.
        OrCourseComunication::create([
            'name' => $this->name,
            'action' => $this->action,
            'or_channel_id' => $this->channel,
            'or_course_id' => $this->online_registration_course_id,
            'message' => $this->reconstruirJsonEstructura(), // Esto ya incluye todos los campos
        ]);

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Comunicación guardada correctamente con todos los campos.'
        ]);

        $this->cancel();
    }



    public function updatedChannel($value)
    {
        $canal = OnlineRegistrationChannel::find($value);

        if ($canal && $canal->structure) {
            $estructura = json_decode($canal->structure, true);

            $this->channelStructure = $this->transformarJsonAInputs($estructura);
        } else {
            $this->channelStructure = [];
        }
    }

    private function buscarCamposVacios($array, $padre = '')
    {
        $vac = [];
        foreach ($array as $key => $valor) {
            $nombreCompleto = $padre ? $padre . '.' . $key : $key;

            if (is_array($valor)) {
                if (empty(array_filter($valor, fn($v) => $v !== '' && $v !== null))) {
                    $vac[$nombreCompleto] = '';
                } else {
                    $vac = array_merge($vac, $this->buscarCamposVacios($valor, $nombreCompleto));
                }
            } elseif ($valor === '' || $valor === null) {
                $vac[$nombreCompleto] = '';
            }
        }
        return $vac;
    }
    public function cargarEstructura()
    {
        $this->channelStructure = []; // Reset

        $canal = OnlineRegistrationChannel::find($this->channel);

        if ($canal && $canal->structure) {
            $estructura = json_decode($canal->structure, true);

            // Aplanar
            foreach ($estructura as $grupo => $campos) {
                foreach ($campos as $clave => $valor) {
                    // Si es un array como 'participants', convertirlo a string separado por comas
                    if (is_array($valor)) {
                        $valor = implode(',', $valor);
                    }

                    $this->channelStructure["{$grupo}_{$clave}"] = $valor;
                }
            }
        }
    }

    private function transformarJsonAInputs(array $estructura): array
    {
        $datosPlanos = [];

        foreach ($estructura as $grupo => $campos) {
            foreach ($campos as $clave => $valor) {
                if (is_array($valor)) {
                    $valor = implode(',', $valor); // Si es array, convertir a string
                }
                $datosPlanos["{$grupo}_{$clave}"] = $valor;
            }
        }

        return $datosPlanos;
    }




    private function reconstruirJsonEstructura(): string
    {
        $estructura = [];

        foreach ($this->channelStructure as $campoPlano => $valor) {
            if (!str_contains($campoPlano, '_')) {
                continue;
            }

            [$grupo, $clave] = explode('_', $campoPlano, 2);

            if ($clave === 'participants') {
                $valor = array_map('trim', explode(',', $valor));
            }

            $estructura[$grupo][$clave] = $valor;
        }

        return json_encode($estructura, JSON_UNESCAPED_UNICODE);
    }

    public function edit($id)
    {
        $this->or_course_comunication = $id;
        $orComunication = OrCourseComunication::find($id);

        $this->name = $orComunication->name;
        $this->action = $orComunication->action;
        $this->message = $orComunication->message;
        $this->channel = $orComunication->onlineRegistrationChannel->id;

        $estructura = json_decode($orComunication->message, true) ?? [];
        $this->channelStructure = $this->transformarJsonAInputs($estructura); // <- esta es la línea clave
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'action' => 'required|string',
            'channel' => 'required',
        ]);

        $comunicacion = OrCourseComunication::find($this->or_course_comunication);

        if (!$comunicacion) {
            session()->flash('error', 'Comunicación no encontrada.');
            return;
        }

        $comunicacion->update([
            'name' => $this->name,
            'action' => $this->action,
            'channel_id' => $this->channel,
            'message' => $this->reconstruirJsonEstructura(), // Aquí se guarda todo
        ]);

        $this->cancel();
        session()->flash('success', 'Comunicación actualizada exitosamente.');
    }



    private function extraerCamposEditables($array, $prefijo = '')
    {
        $campos = [];

        foreach ($array as $clave => $valor) {
            $nombreCompleto = $prefijo ? "{$prefijo}.{$clave}" : $clave;

            if (is_array($valor)) {
                // Si es array y tiene un solo valor vacío, mostramos
                if (count($valor) === 1 && empty($valor[0])) {
                    $campos[$nombreCompleto] = '';
                } else {
                    $campos += $this->extraerCamposEditables($valor, $nombreCompleto);
                }
            } elseif (empty($valor)) {
                $campos[$nombreCompleto] = '';
            }
        }

        return $campos;
    }

    public function delete($id)
    {
        $this->or_course_comunication = $id;
    }

    public function destroy()
    {
        $orCourseComunication = OrCourseComunication::find($this->or_course_comunication);

        if (!$orCourseComunication) {
            session()->flash('error', 'Comunicación no encontrada.');
            return;
        }

        $orCourseComunication->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Comunicación eliminada correctamente']);
        $this->cancel();
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->action = '';
        $this->message = '';
        $this->channel = '';
        $this->channelStructure = [];
    }
}
