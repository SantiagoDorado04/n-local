<?php

namespace App\Http\Livewire\Interviews;

use Livewire\Component;
use App\Services\PlayHuntService;

class InterviewsAnswersComponent extends Component
{
    public $guid;
    public $interview;
    public $questions = [];
    public $topic;
    public $responses = [];
    public $selectedVideoUrl = '';
    public $searchName = '';

    protected $playHuntService;

    public function mount($guid)
    {
        $this->guid = $guid;
        $this->playHuntService = new PlayHuntService();
        $this->loadInterview();
        $this->loadResponses();
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
            $this->interview = $this->playHuntService->getInterview($this->guid);
            $this->questions = $this->interview['questions'];
            $this->topic = $this->interview['topic'];
        } catch (\Exception $e) {
            $this->interview = null;
        }
    }

    public function loadResponses()
    {
        try {
            $this->responses = $this->playHuntService->getInterviewResponse($this->guid);
        } catch (\Exception $e) {
            $this->responses = [];
            $this->emit('alert', ['type' => 'error', 'message' => 'Error al cargar las respuestas de la entrevista.']);
        }
    }

    public function selectVideo($url)
    {
        $this->selectedVideoUrl = $url;
        $this->emit('openModal');
    }

    public function updatedSearchName()
    {
        $service = $this->getPlayHuntService();
        if ($service) {
            if (!empty($this->searchName)) {
                $filteredResponses = array_filter($this->responses, function ($response) {
                    $search = strtolower($this->searchName);
                    return strpos(strtolower($response['candidate_name']), $search) !== false ||
                        strpos(strtolower($response['candidate_email']), $search) !== false ||
                        strpos(strtolower($response['candidate_phone']), $search) !== false;
                });

                $this->responses = $filteredResponses;
            } else {
                $this->loadResponses();
            }
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'El servicio PlayHunt no está disponible.']);
        }
    }

    public function render()
    {
        return view('livewire.interviews.interviews-answers-component', [
            'responses' => $this->responses,
        ]);
    }
}