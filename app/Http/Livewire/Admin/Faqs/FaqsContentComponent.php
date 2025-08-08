<?php

namespace App\Http\Livewire\Admin\Faqs;

use Livewire\Component;
use App\Faq;

class FaqsContentComponent extends Component
{
    public $title,
        $slug,
        $description_question,
        $attached_question,
        $category_faq_id,
        $state,
        $description_response,
        $attached_response,
        $faqId,
        $faq;

    public $activeField = 'description_response';

    public function mount($id)
    {
        $this->faqId = $id;
        $this->faq = Faq::find($this->faqId);
    }

    public function render()
    {
        return view('livewire.admin.faqs.faqs-content-component', [
            'faq' => $this->faq
        ]);
    }

    public function store()
    {
        $this->validate([
            $this->activeField => 'required',
            'attached_question' => 'nullable|file',
            'attached_response' => 'nullable|file',
        ]);

        $faq = Faq::find($this->faqId);
        $faq->{$this->activeField} = $this->{$this->activeField};

        if ($this->activeField == 'description_question' && $this->attached_question) {
            $faq->attached_question = $this->attached_question->store('public/faqs');
        }
        if ($this->activeField == 'description_response' && $this->attached_response) {
            $faq->attached_response = $this->attached_response->store('public/faqs');
        }

        $faq->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Contenido actualizado correctamente']);
    }

    public function reply($id)
    {
        $this->activeField = 'description_response';
        $this->faqId = $id;
        $this->faq = Faq::find($id);
    }
}
