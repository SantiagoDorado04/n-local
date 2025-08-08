<?php

namespace App\Http\Livewire\Admin\Proposals;

use App\Contact;
use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;
use App\ContactsProposal;
use App\ProposalTemplate;
use PhpOffice\PhpWord\TemplateProcessor;

class ProposalManagementComponent extends Component
{

    public $searchContact;

    public $templateId,
        $contactId,
        $proposalId;

    public $contactProposal = [],
        $contactProposalId;

    public $answers = [];

    /**
     * The function retrieves data from the database and passes it to a view for rendering in a
     * proposal management component.
     * 
     * @return The `render()` function is returning a view with the variables ``,
     * ``, and `` passed to it. The view being returned is
     * `livewire.admin.proposals.proposal-management-component`.
     */
    public function render()
    {
        $templates = ProposalTemplate::all();
        $contacts = Contact::where('storage', '=', 'primer-cloud')
            ->get();
        $proposals = ContactsProposal::when($this->searchContact, function ($query, $searchContact) {
            return $query->where('contact_id', '=', $searchContact);
        })
            ->get();

        return view('livewire.admin.proposals.proposal-management-component', [
            'templates' => $templates,
            'contacts' => $contacts,
            'proposals' => $proposals
        ]);
    }

    /**
     * This PHP function adds a new ContactsProposal object with a specified template ID and contact ID,
     * and emits a success alert message.
     */
    public function add()
    {
        $this->validate([
            'templateId' => 'required',
            'contactId' => 'required'
        ], [], [
            'templateId' => 'propuesta',
            'contactId' => 'contacto'
        ]);

        $proposal = new ContactsProposal();
        $proposal->proposal_template_id = $this->templateId;
        $proposal->contact_id = $this->contactId;
        $proposal->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Popuesta agregada correctamente']);
        $this->cancel();
    }

    /**
     * This PHP function generates a Word document proposal by replacing placeholders with data from a
     * database and downloads it.
     * 
     * @param dataP  is an array parameter that contains two values. The first value is the ID of
     * a ContactsProposal object, and the second value is the version number of the proposal. These
     * values are used to retrieve the necessary data from the database and generate a Word document
     * based on a template. The generated document
     * 
     * @return a response with a downloaded Word document file. The file name is "Propuesta {contact
     * name} (Version {version}).docx".
     */
    public function generate($dataP)
    {
        $proposal = ContactsProposal::find($dataP[0]);

        //Get Docx File
        $template = ProposalTemplate::find($proposal->proposal_template_id);
        $templateFile = asset($template->url_file);
        $templateObject = new TemplateProcessor($templateFile);

        //Get data contact
        $contact = Contact::select('name', 'nit', 'email', 'phone', 'whatsapp')
            ->find($proposal->contact_id);

        //Replace data contact
        foreach ($contact->toArray() as $key => $value) {
            $templateObject->setValue($key, $value);
        }

        //Get answers
        $data = json_decode($proposal->answers, true);
        

        if (!empty($data) && isset($data['answers'])) {
            //Get version answers
            $answers = $data['answers'][$dataP[1]] ?? [];
            foreach ($answers as $key => $value) {
                $templateObject->setValue($key, $value);
            }
        }

        //Save Docx file and download
        $wordDocumentFile = $templateObject->save();

        $headers = [
            'Content-Type' => 'application/msword',
            'Cache-Control' => 'max-age=0'
        ];

        return response()->download($wordDocumentFile, '' .$proposal->proposal->name.' '. $proposal->contact->name . ' (Version ' . $dataP[1]+1 . ').docx', $headers);
    }

    /**
     * This PHP function retrieves the latest answers from a ContactsProposal object with a given ID.
     * 
     * @param id The parameter "id" is the identifier of a ContactsProposal object that the function
     * "getProposalContact" is retrieving from the database.
     */
    public function getProposalContact($id)
    {
        $this->contactProposal = ContactsProposal::find($id);

        $this->contactProposalId = $id;

        $data = json_decode($this->contactProposal->answers, true);

        if (!empty($data) && isset($data['answers'])) {

            $answers = $data['answers'];
            $this->answers = end($answers);
        }
    }

    /**
     * This PHP function updates a contact proposal's answers with new form data.
     * 
     * @param formData It is a variable that contains the data submitted by the user through a form. It
     * is passed as a parameter to the `submit` function.
     */
    public function submit($formData)
    {
        $this->contactProposal = ContactsProposal::find($this->contactProposalId);
        $data = json_decode($this->contactProposal->answers, true);

        $data['answers'][] = $formData;

        $answers = ContactsProposal::find($this->contactProposalId);
        $answers->answers = $data;
        $answers->update();

        $this->cancel();
        
    }

    public function getAnswers($dataP){
        $this->contactProposal = ContactsProposal::find($dataP[0]);

        $this->contactProposalId = $dataP[0];

        $data = json_decode($this->contactProposal->answers, true);

        if (!empty($data) && isset($data['answers'])) {
            $this->answers = $data['answers'][$dataP[1]];
        }
    }

    public function resetInputFields()
    {
        $this->templateId = '';
        $this->contactId = '';
        $this->proposalId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
        $this->emit('reset-form');
    }

    public function send($dataP)
    {
    }
}

