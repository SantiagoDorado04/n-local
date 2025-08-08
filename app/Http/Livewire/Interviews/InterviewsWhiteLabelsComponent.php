<?php

namespace App\Http\Livewire\Interviews;

use Livewire\Component;
use App\Services\PlayHuntService;

class InterviewsWhiteLabelsComponent extends Component
{
    protected $playHuntService;

    public function __construct()
    {
        $this->playHuntService = new PlayHuntService();
    }
    
    public function render()
    {
        try {
            $witheLabels = $this->playHuntService->getWhiteLabels();
        } catch (\Exception $e) {
            $witheLabels = [];
        }
        
        return view('livewire.interviews.interviews-white-labels-component',[
            'witheLabels' => $witheLabels
        ]);
    }
}
