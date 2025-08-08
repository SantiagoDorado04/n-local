<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingMassive;

use App\Contact;
use DOMDocument;
use App\Campaign;
use App\Models\User;
use App\EmailTemplate;
use App\CommercialForm;
use App\CommercialLand;
use App\CampaignContact;
use App\CommercialAction;
use App\Jobs\SendEmailJob;
use App\CommercialStrategy;
use Livewire\WithPagination;
use App\Jobs\SendEmailMassiveJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Livewire\Admin\CommercialManagement\MailingIndividual\MailingIndividualComponent;

class MailingMassiveComponent extends MailingIndividualComponent
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //Vars Filter
    public $searchName, $searchStorage, $searchRate, $searchStart, $searchEnd;

    public $lands,
        $strategies,
        $actions,
        $forms;

    public $landId,
        $strategyId,
        $actionId,
        $formId;

    //User to assign schedule
    public $users;

    public $contacts;

    public $errorContacts;

    public $selectAll, $selected = [];

    public $campaignName, $campaignDescription, $campaignId, $status;

    public $linksContent = [];

    public function mount($id = NULL)
    {
        //Lists dropdowns filter
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();
        $this->forms = CommercialForm::all();

        //List Users
        $this->users = User::where('role_id', '=', '3')
            ->get();

        if ($id != '') {
            $campaign = Campaign::find($id);

            $this->campaignId = $campaign->id;

            $this->campaignName = $campaign->name;
            $this->campaignDescription = $campaign->description;
            $this->subject = $campaign->subject;
            $this->content = $campaign->content;
            $this->status = $campaign->status;

            $this->selected = $campaign->contacts->pluck('contact_id')->toArray();
        }
    }

    public function render()
    {
        $this->contacts = Contact::select(
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
            ->when($this->searchName, function ($query, $searchName) {
                $this->selected = [];
                $this->resetPage();
                return $query->where('contacts.name', 'like', '%' . $searchName . '%');
            })
            ->when($this->searchStorage, function ($query, $searchStorage) {
                $this->resetPage();
                $this->selected = [];
                return $query->where('contacts.storage', '=', $searchStorage);
            })
            ->when($this->searchRate, function ($query, $searchRate) {
                $this->resetPage();
                $this->selected = [];
                return $query->where('contacts.rate', '=', $searchRate);
            })
            ->when($this->searchStart, function ($query, $searchStart) {
                if ($this->searchEnd != '') {
                    $this->resetPage();
                    $this->selected = [];
                    return $query->whereBetween('contacts.created_at', [$searchStart, $this->searchEnd]);
                }
            })
            ->when($this->actionId, function ($query, $actionId) {
                $this->resetPage();
                $this->selected = [];
                return $query->where('contacts.commercial_action_id', '=',  $actionId);
            })
            ->when($this->strategyId, function ($query, $strategyId) {
                $this->resetPage();
                $this->selected = [];
                return $query->where('commercial_strategy_id', '=',  $strategyId);
            })
            ->when($this->landId, function ($query, $landId) {
                $this->resetPage();
                $this->selected = [];
                return $query->where('commercial_land_id', '=',  $landId);
            })
            ->when($this->formId, function ($query, $formId) {
                $this->resetPage();
                $this->selected = [];
                return $query->where('contacts.commercial_form_id', '=',  $formId);
            })
            ->orderBy('contacts.created_at', 'desc')
            ->paginate(10);

        //Links pagination
        $links = $this->contacts;

        //Items query result as array
        $this->contacts = collect($this->contacts->items());

        //Validation if on the page there are selected items
        $all = false;

        //Foreach contacts, if all are selected, selected the chechbox selectAll
        foreach ($this->contacts as $contact) {
            if (in_array($contact->id, $this->selected)) {
                $all = true;
            } else {
                $all = false;
                break;
            }
        }

        if ($all == true) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }

        //Get email templates
        $templates = EmailTemplate::all();

        $this->updatedContent();

        $this->emit('select2');

        return view('livewire.admin.commercial-management.mailing-massive.mailing-massive-component', [
            'contacts' => $this->contacts,
            'links' => $links,
            'templates' => $templates
        ]);

        $this->emit('select2');
    }

    public function updatedSelectAll($value)
    {
        //If all contacts are selected, all checkbox are marked
        if ($value == true) {
            foreach ($this->contacts as $contact) { {
                    if (($key = array_search($contact['id'], $this->selected)) !== false) {
                        unset($this->selected[$key]);
                    }
                }
            }

            foreach ($this->contacts as $contact) {
                array_push($this->selected, $contact['id']);
            }
        }

        //Contacts per page are unselect
        else {
            foreach ($this->contacts as $contact) { {
                    if (($key = array_search($contact['id'], $this->selected)) !== false) {
                        unset($this->selected[$key]);
                    }
                }
            }
        }
        $this->selected = array_values($this->selected);
    }

    public function updatedContent()
    {
        if ($this->content != '') {
            $this->linksContent = [];
            $dom = new DOMDocument();
            $dom->loadHTML($this->content);
            $links = $dom->getElementsByTagName('a');

            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                $title = $link->nodeValue;
                $this->linksContent[] = array('url' => $href, 'title' => $title, 'date_click' => '');
            }
        } else {
            $this->linksContent = [];
        }
    }

    public function save($value)
    {
        $this->validate([
            'subject' => 'required',
            'content' => 'required',
            'campaignName' => 'required',
            'campaignDescription' => 'required'
        ], [
            'selected.required' => 'Seleccionar al menos un contacto',
            'content.required' => 'El contenido del correo no debe estar vacío'
        ], [
            'to' => 'destinatario',
            'subject' => 'asunto',
            'campaignName' => 'nombre de la campaña',
            'campaignDescription' => 'descripción'
        ]);

        $campaign = Campaign::updateOrCreate(
            ['id' => $this->campaignId],
            [
                'name' => $this->campaignName,
                'description' => $this->campaignDescription,
                'subject' => $this->subject,
                'content' => $this->content,
                'links' => json_encode($this->linksContent),
                'created_by' => Auth::user()->id
            ]
        );


        if ($this->campaignId != '') {
            $camp = Campaign::find($this->campaignId);
            $campaign->contacts()->delete();
        }

        foreach ($this->selected as $contact) {

            $info = Contact::find($contact);

            //Save campaign contact

            $contact = new CampaignContact();
            $contact->campaign_id = $campaign->id;
            $contact->contact_id = $info->id;
            $contact->links = json_encode($this->linksContent);
            $contact->save();
        }

        if ($value == 'sent') {

            if ($this->campaignId != '') {
                $camp = Campaign::find($this->campaignId);
                $campaign->contacts()->delete();
            }

            foreach ($this->selected as $contact) {

                $info = Contact::find($contact);

                //Save campaign contact

                $contact = new CampaignContact();
                $contact->campaign_id = $campaign->id;
                $contact->contact_id = $info->id;
                $contact->links = json_encode($this->linksContent);
                $contact->save();
            }

            foreach ($this->selected as $cont) {

                $contact = Contact::find($cont);
                $info2 = CampaignContact::where('campaign_id', '=', $campaign->id)->where('contact_id', '=', $cont)->first();

                 if ($contact!='') {
                    $vars = [
                        '{{nit}}',
                        '{{name}}',
                        '{{address}}',
                        '{{phone}}',
                        '{{email}}',
                        '{{whatsap}}',
                        '{{website}}',
                        '{{contact_person_name}}',
                        '{{contact_person_email}}',
                        '{{leader_name}}',
                        '{{leader_email}}',
                        '{{leader_phone}}'
                    ];
        
                    $info = [
                        $contact->nit,
                        $contact->name,
                        $contact->address,
                        $contact->phone,
                        $contact->email,
                        $contact->whatsap,
                        $contact->website,
                        $contact->contact_person_name,
                        $contact->contact_person_email,
                        $contact->leader_name,
                        $contact->leader_email,
                        $contact->leader_phone,
                    ];
        
                    $content = $this->content;
        
                    $cont = 0;
                    foreach ($vars as $var) {
                        $content = str_replace($var, $info[$cont], $content);
                        $cont++;
                    }
                }

                //Send email
                $data = [
                    'content' => $content,
                    'email' => $contact->email,
                    'subject' => $this->subject,
                    'cc' => $this->cc,
                    'cco' => $this->cco,
                    'contact' => $info2->id,
                ];
                dispatch(new SendEmailMassiveJob($data));
            }

            $campaign->status = 'sent';
            $campaign->send_date = date('Y-m-d H:i:s');
            $campaign->update();

            Session::flash('mensaje', ' Campaña enviada correctamente');
            Session::flash('tipo_mensaje', 'success');

            return redirect()->route('mailing.massive.outbox');
        } else {

            $campaign->status = 'draft';
            $campaign->update();

            Session::flash('mensaje', ' Campaña  guardada correctamente');
            Session::flash('tipo_mensaje', 'success');

            return redirect()->route('mailing.massive.outbox');
        }
    }

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

        $this->emit('select2');
    }

    public function updatedStrategyId($strategy)
    {
        if ($strategy != '') {
            $this->actions = CommercialAction::where('commercial_strategy_id', '=', $strategy)->get();
        } else {
            $this->actions = collect();
            $this->strategyId = '';
            $this->actionId = '';
        }

        $this->emit('select2');
    }
}
