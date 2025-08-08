<?php

namespace App\Http\Livewire\Admin\Contacts;

use App\Contact;
use App\CommercialLand;
use Livewire\Component;
use App\CommercialAction;
use App\ContactsSchedule;
use App\CommercialStrategy;
use Livewire\WithPagination;
use TCG\Voyager\Models\User;
use Livewire\WithFileUploads;
use App\Exports\ContactsExport;
use App\Imports\ContactsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ContactsComponent extends Component
{
    use WithPagination;

    use WithFileUploads;


    protected $paginationTheme = 'bootstrap';

    //Vars Filter
    public $searchName, $searchStorage, $searchRate, $searchStart, $searchEnd;

    public $lands, $strategies, $actions;
    public $landId, $strategyId, $actionId;

    //User to assign schedule
    public $users;

    //File to import contacts
    public $fileContacts, $imports;

    //Vars to edit rate and assign schedule
    public $contactId;
    public $rate, $userId, $priority, $dateToContact, $timeToContact, $observationsContact;
    public $schedule;

    //Failures import file
    public $failures;

    protected $listeners = ['resetFailures' => 'resetFailures'];

    public function mount()
    {
        //Lists dropdowns filter
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();

        //List Users
        $this->users = User::where('role_id', '=', '3')->get();

    }

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
            ->where('contacts.storage','!=','primer-cloud')
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
            ->orderBy('contacts.created_at', 'desc')
            ->paginate(10);

            $firstItem = $contacts->firstItem();
            $lastItem = $contacts->lastItem();


            $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$contacts->total()} registros";

        return view('livewire.admin.contacts.contacts-component', [
            'contacts' => $contacts,
            'paginationText'=>$paginationText
            
        ]);
    }

    /**
     * If the land id is not empty, then get all the strategies that have that land id
     *
     * @param land The id of the land that was selected.
     */
    public function updatedLandId($land)
    {
        if ($land != '') {
            $this->strategies = CommercialStrategy::where('commercial_land_id', '=', $land)->get();
        } else {
            $this->strategies = collect();
            $this->actions = collect();
            $this->landId = '';
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    /**
     * If the strategy is not empty, then get all the actions that belong to that strategy. Otherwise,
     * set the actions to an empty collection and set the strategy and action ids to empty strings
     *
     * @param strategy The strategy id
     */
    public function updatedStrategyId($strategy)
    {
        if ($strategy != '') {
            $this->actions = CommercialAction::where('commercial_strategy_id', '=', $strategy)->get();
        } else {
            $this->actions = collect();
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    /**
     * > This function saves the rate of a contact
     *
     * @param id The id of the contact you want to rate.
     */
    public function saveRate($id)
    {
        $this->contactId = $id;
        $contact = Contact::find($this->contactId);
        if ($contact->rate != '') {
            $this->rate = $contact->rate;
        }
    }

    /**
     * It validates the rate, finds the contact, updates the rate, cancels the modal, and emits an
     * alert
     */
    public function storeRate()
    {

        $this->validate(['rate' => 'required']);

        $contact = Contact::find($this->contactId);
        $contact->rate = $this->rate;
        $contact->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Calificación guardada correctamente.']);
        $this->cancel();
    }

    /**
     * > This function saves the schedule for the contact with the given id
     *
     * @param id The id of the contact you want to save the schedule for.
     */
    public function saveSchedule($id)
    {
        $this->contactId = $id;
    }

    /**
     * It validates the form, creates a new schedule, saves it, and then emits an alert
     */
    public function storeSchedule()
    {
        $this->validate([
            'userId' => 'required',
            'priority' => 'required'
        ], [], [
            'userId' => 'agente de contacto',
            'priority' => 'prioridad'
        ]);

        $schedule = new ContactsSchedule();
        $schedule->contact_id = $this->contactId;
        $schedule->user_id = $this->userId;
        $schedule->assignment_date = date('Y-m-d H:i:s');
        $schedule->assigned_by = Auth::user()->id;
        $schedule->date_to_contact = $this->dateToContact;
        $schedule->time_to_contact = $this->timeToContact;
        $schedule->observations_contact = $this->observationsContact;
        $schedule->priority = $this->priority;
        $schedule->status = 'assigned';
        $schedule->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Agente asignado correctamente.']);
        $this->cancel();
    }

    public function editSchedule($id)
    {
        $this->schedule = ContactsSchedule::find($id);
        $this->userId = $this->schedule->user_id;
        $this->dateToContact = $this->schedule->date_to_contact;
        $this->timeToContact = $this->schedule->time_to_contact;
        $this->observationsContact = $this->schedule->observations_contact;
        $this->priority = $this->schedule->priority;
    }

    public function updateSchedule()
    {
        $this->validate([
            'userId' => 'required',
            'priority' => 'required'
        ], [], [
            'userId' => 'agente de contacto',
            'priority' => 'prioridad'
        ]);

        $schedule = ContactsSchedule::find($this->schedule->id);
        $schedule->user_id = $this->userId;
        $schedule->assignment_date = date('Y-m-d H:i:s');
        $schedule->assigned_by = Auth::user()->id;
        $schedule->date_to_contact = $this->dateToContact;
        $schedule->time_to_contact = $this->timeToContact;
        $schedule->observations_contact = $this->observationsContact;
        $schedule->priority = $this->priority;
        $schedule->status = 'assigned';
        $schedule->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Agente actualizado correctamente.']);
        $this->cancel();
    }

    public function infoSchedule($id)
    {
        $this->schedule = ContactsSchedule::find($id);
    }

    /**
     * It exports the contacts to an excel file.
     */
    public function export()
    {

        $contacts = Contact::select(
            'contacts.*',
            DB::raw('DATE_FORMAT(contacts.created_at, "%d-%m-%Y %h:%i:%s") as created'),
            'commercial_lands.name as commercial_land_name',
            'commercial_strategies.name as commercial_strategy_name',
            'commercial_actions.name as commercial_action_name',
            'commercial_forms.name as commercial_form_name'

        )
            ->join('commercial_form_actions', 'commercial_form_actions.id', '=', 'contacts.form_action_id')
            ->join('commercial_forms', 'commercial_forms.id', '=', 'commercial_form_actions.commercial_form_id')
            ->join('commercial_actions', 'commercial_actions.id', '=', 'commercial_form_actions.commercial_action_id')
            ->join('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->join('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
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
            ->get();

        return (new ContactsExport($contacts))
            ->download('contactos.xlsx', \Maatwebsite\Excel\Excel::XLSX);

        $this->emit('alert', ['type' => 'success', 'message' => 'Listado exportado correctamente.']);
    }

    public function resetFailures()
    {
        $this->failures = '';
    }

    /**
     * It uploads the file to the server, then closes the modal, then sets the file to an empty string,
     * then emits an alert
     */
    public function uploadContacts()
    {
        $this->failures = '';

        $this->validate([
            'fileContacts' => 'file|mimes:xlsx',
        ]);

        $import = new ContactsImport();
        try {
            $import->import($this->fileContacts);

            $this->emit('alert', ['type' => 'success', 'message' =>  'Archivo de contactos cargado correctamente, ' . $import->getRowCount() . ' contactos importados']);
            $this->cancel();

            $this->fileContacts = '';
            $this->failures = '';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->failures = $e->failures();

            foreach ($this->failures as $failure) {
                $failure->row();
                $failure->attribute();
                $failure->errors();
                $failure->values();
            }
        }
    }

    /**
     * It resets the input fields.
     */
    public function resetInputFields()
    {
        $this->rate = '';
        $this->contactId = '';
        $this->userId = '';
        $this->priority = '';
        $this->fileContacts = '';
        $this->failures = '';
    }

    /**
     * > Reset the input fields, error bag, validation, and emit a close-modal event
     */
    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    /**
     * > When the `select2` event is emitted, the `hydrate` function is called
     */
    public function hydrate()
    {
        $this->emit('select2');
    }
}
