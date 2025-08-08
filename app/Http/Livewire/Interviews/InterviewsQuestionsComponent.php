<?php

namespace App\Http\Livewire\Interviews;

use Livewire\Component;
use App\Services\PlayHuntService;

class InterviewsQuestionsComponent extends Component
{
    public $guid;
    public $interview;
    public $questions = [];
    public $newQuestion = '';
    public $topic;

    protected $playHuntService;

    protected $rules = [
        'topic' => 'required|string|max:255',
        'questions.*' => 'required|string|max:255',
    ];

    public function mount($guid)
    {
        $this->guid = $guid;
        $this->playHuntService = new PlayHuntService();
        $this->loadInterview();
    }

    public function getPlayHuntService()
    {
        if (!$this->playHuntService) {
            $this->playHuntService = new PlayHuntService();
        }
        return $this->playHuntService;
    }

    public function loadInterview()
    {
        try {
            $this->interview = $this->getPlayHuntService()->getInterview($this->guid);
            $this->questions = array_map(function ($q) {
                return $q['question'];
            }, $this->interview['questions']);
    
            $this->topic = $this->interview['topic'];
        } catch (\Exception $e) {
            $this->interview = null;
            $this->emit('alert', ['type' => 'error', 'message' => 'Error al cargar la entrevista: ' . $e->getMessage()]);
        }
    }

    public function addQuestion()
    {
        $this->validate([
            'newQuestion' => 'required|string|max:255',
        ], [
            'newQuestion.required' => 'Ingrese el texto de la pregunta',
        ]);

        $this->questions[] = $this->newQuestion;
        $this->newQuestion = '';
    }

    public function updateQuestion($index, $newText)
    {
        $this->validate([
            'questions.' . $index => 'required|string|max:255',
        ], [
            'questions.' . $index . '.required' => 'Ingrese el texto de la pregunta',
        ]);

        $this->questions[$index] = $newText;
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function updateQuestionsOrder($orderedIds)
    {
        $this->questions = array_values(array_replace(array_flip($orderedIds), $this->questions));
    }

    public function saveInterview()
    {
        $this->validate([
            'topic' => 'required',
            'questions' => 'required|array|min:1',
        ],[
            'topic.required' => 'Ingrese el tema de la entrevista',
            'questions.required' => 'Debe agregar al menos una pregunta',
            'questions.min' => 'Debe agregar al menos una pregunta',
        ]);

        $service = $this->getPlayHuntService();
        if ($service) {
            try {
                $service->editInterview($this->guid, $this->topic, $this->questions);
                $this->emit('alert', ['type' => 'success', 'message' => 'Entrevista actualizada con éxito.']);
            } catch (\Exception $e) {
                $this->emit('alert', ['type' => 'error', 'message' => 'Error al actualizar la entrevista: ' . $e->getMessage()]);
            }
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'El servicio PlayHunt no está disponible.']);
        }
    }

    public function render()
    {
        return view('livewire.interviews.interviews-questions-component');
    }
}
