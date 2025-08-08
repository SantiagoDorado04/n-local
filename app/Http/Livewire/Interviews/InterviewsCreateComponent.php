<?php

namespace App\Http\Livewire\Interviews;

use App\Interview;
use App\Models\Step;
use Livewire\Component;
use App\Services\PlayHuntService;
use Illuminate\Support\Facades\Route;

class InterviewsCreateComponent extends Component
{
    public $topic = '';
    public $questions = [];
    public $newQuestion = '';
    protected $playHuntService;

    public $stepId, $stageId;
    public $currentRouteName;

    protected $rules = [
        'topic' => 'required|string|max:255',
        'questions.*' => 'required|string|max:255',
    ];

    public function mount($id = null)
    {
        $this->stepId= $id;
        $step = Step::find($this->stepId);
        $this->stageId = $step->stage_id;
        $this->playHuntService = new PlayHuntService();
        $this->currentRouteName = Route::currentRouteName();
        $interview = Interview::where('step_id','=',$this->stepId)->first();

        if($interview){
            return redirect()->route('video-interviews.update', ['guid' => $interview->interview]);
        }
    }

    public function getPlayHuntService()
    {
        if (!$this->playHuntService) {
            $this->playHuntService = new PlayHuntService();
        }
        return $this->playHuntService;
    }

    public function addQuestion()
    {
        $this->validate([
            'newQuestion' => 'required|string|max:255',
        ], [
            'newQuestion.required' => 'Ingrese el texto de la pegunta',
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

    public function createInterview()
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
                $response = $service->createInterview($this->topic, $this->questions);

                if (isset($response['guid'])) {

                    if ($this->currentRouteName === 'video-interviews') {
                        $interview = new Interview();
                        $interview->step_id = $this->stepId;
                        $interview->interview = $response['guid'];
                        $interview->save();

                        $guid = $response['guid'];
                        session()->flash('message', 'Entrevista creada correctamente!');
                        return redirect()->route('steps', ['id' => $this->stageId]);
                    }else{
                        $guid = $response['guid'];
                        session()->flash('message', 'Entrevista creada correctamente!');
                        return redirect()->route('video-interviews.update', ['guid' => $guid]);
                    }
                } else {
                    $this->emit('alert', ['type' => 'error', 'message' => 'Error al crear una entrevista']);
                }
            } catch (\Exception $e) {
                $this->emit('alert', ['type' => 'error', 'message' => 'Ha ocurrido un error: ' . $e->getMessage()]);
            }
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'El servicio PlayHunt no está disponible.']);
        }
    }

    public function render()
    {
        return view('livewire.interviews.interviews-create-component');
    }
}
