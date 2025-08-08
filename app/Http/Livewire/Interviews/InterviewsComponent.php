<?php

namespace App\Http\Livewire\Interviews;

use Livewire\Component;
use App\Services\PlayHuntService;

class InterviewsComponent extends Component
{
    public $searchName = '';
    public $interviewToDelete = null;
    protected $playHuntService;

    public function __construct()
    {
        $this->playHuntService = new PlayHuntService();
    }

    public function render()
    {
        try {
            $interviews = $this->playHuntService->request('interview/get-all-interviews');
            if (!empty($this->searchName)) {
                $interviews = array_filter($interviews, function ($interview) {
                    return stripos($interview['topic'], $this->searchName) !== false;
                });
            }

        } catch (\Exception $e) {
            $interviews = [];
        }

        return view('livewire.interviews.interviews-component', [
            'interviews' => $interviews
        ]);
    }

    public function selectInterviewToDelete($guid)
    {
        $this->interviewToDelete = $guid;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDelete()
    {
        if ($this->interviewToDelete) {
            try {
                $this->playHuntService->deleteInterview($this->interviewToDelete);
                $this->emit('alert', ['type' => 'success', 'message' => 'Entrevista eliminada con éxito.']);
                $this->interviewToDelete = null;
                $this->render();
            } catch (\Exception $e) {
                $this->emit('alert', ['type' => 'error', 'message' => 'Error al eliminar la entrevista: ' . $e->getMessage()]);
            }
        }
        $this->cancel();
    }

    public function cancel()
    {
        $this->emit('close-modal');
    }
}
