<?php

namespace App\Http\Livewire\Admin\Contacts;

use App\Contact;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;

class ContactsCloudComponent extends ContactsComponent
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    

    public function render()
    {
        $contacts = Contact::select(
            'contacts.*',
            'commercial_form_actions.id as commercial_form_action_id',
            'commercial_actions.id as commercial_action_id',
            'commercial_actions.name as commercial_action_name',
            'commercial_forms.id as commercial_form_id',
            'commercial_forms.name as commercial_form_name',
            'commercial_strategies.id as commercial_strategy_id',
            'commercial_strategies.name as commercial_strategy_name',
            'commercial_lands.id as commercial_land_id',
            'commercial_lands.name as commercial_land_name',
            'contacts_schedules.id as schedule_id',
            'contacts_schedules.user_id as schedule_user',
            'contacts_schedules.status as schedule_status'
        )
            ->leftjoin('commercial_forms', 'commercial_forms.id', '=', 'contacts.commercial_form_id')
            ->leftjoin('commercial_actions', 'commercial_actions.id', '=', 'contacts.commercial_action_id')
            ->leftjoin('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->leftjoin('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->leftjoin('commercial_form_actions', 'commercial_form_actions.id', '=', 'contacts.form_action_id')
            ->leftjoin('contacts_schedules', 'contacts_schedules.contact_id', '=', 'contacts.id')
            ->where('contacts.storage','=','primer-cloud')
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('contacts.name', 'like', '%' . $searchName . '%');
            })
            ->when($this->searchStorage, function ($query, $searchStorage) {
                return $query->where('contacts.storage', '=', $searchStorage);
            })
            ->when($this->searchRate, function ($query, $searchRate) {
                return $query->where('contacts.rate', '=', $searchRate);
            })
            ->when($this->searchStart, function ($query, $searchStart) {
                if ($this->searchEnd != '') {
                    return $query->whereBetween('contacts.created_at', [$searchStart, $this->searchEnd]);
                }
            })
            ->when($this->actionId, function ($query, $actionId) {
                return $query->where('commercial_action_id', '=',  $actionId);
            })
            ->when($this->strategyId, function ($query, $strategyId) {
                return $query->where('commercial_strategy_id', '=',  $strategyId);
            })
            ->when($this->landId, function ($query, $landId) {
                return $query->where('commercial_land_id', '=',  $landId);
            })
            ->paginate(10);

            $firstItem = $contacts->firstItem();
            $lastItem = $contacts->lastItem();

            $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$contacts->total()} registros";

            /* dd($contacts); */

        return view('livewire.admin.contacts.contacts-cloud-component', [
            'contacts' => $contacts,
            'paginationText'=>$paginationText
        ]);
    }

    public function editRol($id){
        $this->contactId=$id;
    }

    public function updateRol(){

        $contact=Contact::find($this->contactId);
        $user=User::find($contact->user_id);
        $user->role_id=7;
        $user->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Rol actualizado correctamente.']);
        $this->cancel();
    }
}
