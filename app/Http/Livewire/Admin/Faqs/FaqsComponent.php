<?php

namespace App\Http\Livewire\Admin\Faqs;

use App\Faq;
use App\Categoryfaq;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class FaqsComponent extends Component
{
    use WithFileUploads;

    public $searchName, $searchCategory, $searchState;

    public $title,
        $slug,
        $description_question,
        $attached_question,
        $category_faq_id,
        $state,
        $description_response,
        $attached_response,
        $faqId,
        $faq = [];


    public function render()
    {
        $categories = Categoryfaq::all();
        $user = Auth::user()->role_id;

        $faqs = Faq::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
            ->when($this->searchCategory, function ($query, $searchCategory) {
                return $query->where('category_faq_id', '=', $searchCategory);
            })
            ->when($this->searchState, function ($query, $searchState) {
                return $query->where('state', '=', $searchState);
            });

        $faqs = $faqs->get();

        return view('livewire.admin.faqs.faqs-component', [
            'categories' => $categories,
            'faqs' => $faqs
        ]);
    }


    public function show($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faq = $faq;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description_question' => 'required',
            'attached_question' => 'nullable|file',
            'category_faq_id' => 'required',
        ], [], [
            'title' => 'título',
            'description_question' => 'descripción',
            'attached_question' => 'adjunto',
            'category_faq_id' => 'categoría',
        ]);

        $faq = new Faq();
        $faq->title = $this->title;
        $faq->slug = Str::slug($this->title);
        $faq->description_question = $this->description_question;
        $faq->category_faq_id = $this->category_faq_id;
        $faq->question_user_id = Auth::user()->id;
        $faq->date_question = date('Y-m-d H:i:s');
        $faq->state = 'pregunta';

        if ($this->attached_question != '') {
            $faq->attached_question = $this->attached_question->store('public/faqs');
        }

        $faq->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Faq creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $faq = Faq::findOrFail($id);
        $this->title = $faq->title;
        $this->description_question  = $faq->description_question;
        $this->category_faq_id = $faq->category_faq_id;

        $this->faqId = $faq->id;

        $this->emit('load-cke');
    }

    public function update()
    {

        $this->validate([
            'title' => 'required',
            'description_question' => 'required',
            'attached_question' => 'nullable|file',
            'category_faq_id' => 'required',
        ], [], [
            'title' => 'título',
            'description_question' => 'descripción',
            'attached_question' => 'adjunto',
            'category_faq_id' => 'categoría',
        ]);

        $faq = Faq::find($this->faqId);
        $faq->title = $this->title;
        $faq->slug = Str::slug($this->title);
        $faq->description_question = $this->description_question;
        $faq->category_faq_id = $this->category_faq_id;
        $faq->question_user_id = Auth::user()->id;
        $faq->date_question = date('Y-m-d H:i:s');
        $faq->state = 'pregunta';

        if ($this->attached_question != '') {
            $faq->attached_question = $this->attached_question->store('public/faqs');
        }

        $faq->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Faq actualizada correctamente']);
        $this->cancel();
    }

    public function reply($id)
    {

        $faq = Faq::findOrFail($id);
        $this->title = $faq->title;
        $this->description_question  = $faq->description_question;
        $this->category_faq_id = $faq->category_faq_id;
        $this->description_response = $faq->description_response;

        $this->faqId = $faq->id;

        $this->emit('load-cke');
    }

    public function confirmReply()
    {

        $this->validate([
            'title' => 'required',
            'description_question' => 'required',
            'attached_question' => 'nullable|file',
            'category_faq_id' => 'required',
            'description_response' => 'required'
        ], [], [
            'title' => 'título',
            'description_question' => 'descripción pregunta',
            'attached_question' => 'adjunto',
            'category_faq_id' => 'categoría',
            'description_response' => 'descripción respuesta',
        ]);

        $faq = Faq::find($this->faqId);
        $faq->title = $this->title;
        $faq->slug = Str::slug($this->title);
        $faq->description_question = $this->description_question;
        $faq->category_faq_id = $this->category_faq_id;
        $faq->question_user_id = Auth::user()->id;
        $faq->date_question = date('Y-m-d H:i:s');
        $faq->state = 'respuesta';

        if ($this->attached_question != '') {
            $faq->attached_question = $this->attached_question->store('public/faqs');
        }

        if ($this->attached_response != '') {
            $faq->attached_response = $this->attached_response->store('public/faqs');
        }
        $faq->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Faq actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->faqId = $id;
    }

    public function destroy()
    {
        $faq = Faq::findOrFail($this->faqId);
        $faq->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Faq eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->description_question = '';
        $this->attached_question = '';
        $this->category_faq_id = '';
        $this->state = '';
        $this->description_response = '';
        $this->attached_response = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
