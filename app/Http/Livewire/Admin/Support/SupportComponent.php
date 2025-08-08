<?php

namespace App\Http\Livewire\Admin\Support;

use App\Support;
use Livewire\Component;
use App\Categorysupport;
use App\SupportsResponse;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SupportComponent extends Component
{
    use WithFileUploads;

    public $supportId,
        $subject,
        $body,
        $support_attached,
        $category_supports_id,
        $level_support,
        $state_support,
        $support = [];

    public $body_response,
        $response_attached,
        $response = [];

    public $searchName,
        $searchCategory,
        $searchState;

    public function render()
    {
        $categories = Categorysupport::all();

        $supports = Support::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
        ->when($this->searchCategory, function ($query, $searchCategory) {
            return $query->where('category_support_id', '=', $searchCategory);
        })
        ->when($this->searchState, function ($query, $searchState) {
            return $query->where('state', '=', $searchState);
        });

        if(Auth::user()->role_id != '1'){
            $supports = $supports->where('support_user_id','=',Auth::user()->id);
        }

        $supports = $supports->get();

        return view('livewire.admin.support.support-component', [
            'categories' => $categories,
            'supports' => $supports
        ]);
    }

    public function show($id){

        $support = Support::find($id);
        $this->support = $support;
    }

    public function store()
    {
        $this->validate([
            'subject' => 'required',
            'body' => 'required',
            'category_supports_id' => 'required',
        ], [], [
            'subject' => 'asunto',
            'body' => 'descriprición',
            'category_supports_id' => 'categoría',
        ]);

        $support = new Support();
        $support->subject = $this->subject;
        $support->slug = Str::slug($this->subject);
        $support->body = $this->body;
        $support->category_supports_id = $this->category_supports_id;
        $support->state_support = 'solicitado';
        $support->support_user_id = Auth::user()->id;
        $support->date_support = date('Y-m-d H:i:s');

        if ($this->support_attached != '') {
            $support->support_attached = $this->support_attached->store('public/support');
        }

        $support->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Faq actualizada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $support = Support::find($id);
        $this->subject = $support->subject;
        $this->body = $support->body;
        $this->category_supports_id = $support->category_supports_id;

        $this->supportId = $support->id;

        $this->emit('load-cke');
    }

    public function update(){
        $this->validate([
            'subject' => 'required',
            'body' => 'required',
            'category_supports_id' => 'required',
        ], [], [
            'subject' => 'asunto',
            'body' => 'descriprición',
            'category_supports_id' => 'categoría',

        ]);

        $support = Support::find($this->supportId);
        $support->subject = $this->subject;
        $support->slug = Str::slug($this->subject);
        $support->body = $this->body;
        $support->category_supports_id = $this->category_supports_id;
        $support->state_support = 'solicitado';
        $support->support_user_id = Auth::user()->id;
        $support->date_support = date('Y-m-d H:i:s');

        if ($this->support_attached != '') {
            $support->support_attached = $this->support_attached->store('public/support');
        }

        $support->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Soporte actualizado correctamente']);
        $this->cancel();
    }

    public function reply($id)
    {

        $support = Support::find($id);
        $this->subject = $support->subject;
        $this->body = $support->body;
        $this->category_supports_id = $support->category_supports_id;

        $this->supportId = $support->id;

        $this->emit('load-cke');
    }

    public function showResponse($id){

        $response = SupportsResponse::find($id);
        $this->response = $response;

    }

    public function editResponse($id){

    }
    public function updateResponse(){

    }

    public function confirmReply()
    {

        $this->validate([
            'subject' => 'required',
            'body' => 'required',
            'category_supports_id' => 'required',
            'body_response' => 'required',
            'response_attached' => 'nullable|file',
            'level_support' => Rule::requiredIf(Auth::user()->role_id == '1'),
            'state_support' => Rule::requiredIf(Auth::user()->role_id == '1'),
        ], [], [
            'subject' => 'asunto',
            'body' => 'descriprición',
            'category_supports_id' => 'categoría',
            'body_response' => 'descripción respuesta',
            'response_attached' => 'adjunto respuesta',
            'level_support' => 'nivel',
            'state_support' => 'estado'
        ]);

        $support = Support::find($this->supportId);
        $support->subject = $this->subject;
        $support->slug = Str::slug($this->subject);
        $support->body = $this->body;
        $support->category_supports_id = $this->category_supports_id;
        $support->state_support = 'solicitado';
        $support->support_user_id = Auth::user()->id;
        $support->date_support = date('Y-m-d H:i:s');

        if ($this->support_attached != '') {
            $support->support_attached = $this->support_attached->store('public/support');
        }
        $support->level_support = $this->level_support;
        $support->state_support = $this->state_support;

        $support->update();

        $response = new SupportsResponse();
        $response->body_response = $this->body_response;
        $response->response_attached = $this->response_attached;
        $response->date_response = date('Y-m-d H:i:s');
        $response->response_user_id = Auth::user()->id;
        $response->support_id = $this->supportId;

        if ($this->response_attached != '') {
            $response->response_attached = $this->response_attached->store('public/support');
        }

        $response->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Respuesta agregada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->subject = '';
        $this->body = '';
        $this->category_supports_id = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
