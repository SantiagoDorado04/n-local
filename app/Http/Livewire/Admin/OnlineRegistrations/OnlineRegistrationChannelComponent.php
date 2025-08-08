<?php

namespace App\Http\Livewire\Admin\OnlineRegistrations;

use App\Models\OnlineRegistrationChannel;
use App\Models\Traits\OrApisTraits\JobQueueTracking;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineRegistrationChannelComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $online_registration_id;
    public $searchName;
    public $mensaje;
    public $channel;
    public $onlineRegistrationChannelId;
    public $name, $url, $structure, $userCreate, $user_created_at, $user_updated_at;


    public function mount($id)
    {
        $this->online_registration_id = $id;
        $this->channel = OnlineRegistrationChannel::where('online_registration_id', $this->online_registration_id)->first();
    }

    public function render()
    {
        $onlineRegistrationChannel = OnlineRegistrationChannel::query()
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->where('online_registration_id', $this->online_registration_id)
            ->paginate(6);

        $firstItem = $onlineRegistrationChannel->firstItem();
        $lastItem = $onlineRegistrationChannel->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$onlineRegistrationChannel->total()} registros";

        return view('livewire.admin.online-registrations.online-registration-channel-component', [
            'onlineRegistrationChannel' => $onlineRegistrationChannel,
            'paginationText' => $paginationText,
        ]);
    }


    public function show($id)
    {
        $onlineRegistrationChannels = OnlineRegistrationChannel::find($id);

        $this->name = $onlineRegistrationChannels->name;
        $this->url = $onlineRegistrationChannels->url;

        // Decodificar el JSON de structure
        $structureData = json_decode($onlineRegistrationChannels->structure, true);
        $this->structure = $structureData;

        $userCreate = User::find($onlineRegistrationChannels->user_created_at);
        $this->user_created_at = $userCreate->name ?? 'No existe el usuario';
        $userUpdate = User::find($onlineRegistrationChannels->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function delete($id)
    {
        $this->onlineRegistrationChannelId = $id;
    }

    public function destroy()
    {
        $onlineRegistrationChannel = OnlineRegistrationChannel::find($this->onlineRegistrationChannelId);
        // $this->name = $onlineRegistrationChannel->name;
        // dd($onlineRegistrationChannel);
        $onlineRegistrationChannel->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Control de registos eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->url = '';
        $this->structure = '';
    }
    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'url' => 'required',
            'structure' => 'required|json',
        ], [], [
            'name' => 'nombre',
            'url' => 'url',
            'structure' => 'estructura',
        ]);

        $onlineRegistrationChannel = new OnlineRegistrationChannel();
        $onlineRegistrationChannel->name = $this->name;
        $onlineRegistrationChannel->url = $this->url;
        $onlineRegistrationChannel->structure = $this->structure;
        $onlineRegistrationChannel->online_registration_id = $this->online_registration_id;
        $onlineRegistrationChannel->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Control de registros creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->onlineRegistrationChannelId = $id;

        $onlineRegistration = OnlineRegistrationChannel::find($id);
        $this->name = $onlineRegistration->name;
        $this->url = $onlineRegistration->url;
        $this->structure = $onlineRegistration->structure;
        $this->online_registration_id = $onlineRegistration->online_registration_id;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'url' => 'required',
            'structure' => 'required|json',
        ], [], [
            'name' => 'nombre',
            'url' => 'url',
            'structure' => 'estructura',
        ]);

        $onlineRegistrationChannel = OnlineRegistrationChannel::find($this->onlineRegistrationChannelId);
        $onlineRegistrationChannel->name = $this->name;
        $onlineRegistrationChannel->url = $this->url;
        $onlineRegistrationChannel->structure = $this->structure;
        $onlineRegistrationChannel->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Control de registros actualizado correctamente']);
        $this->cancel();
    }
}
