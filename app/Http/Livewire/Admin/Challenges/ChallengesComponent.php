<?php

namespace App\Http\Livewire\Admin\Challenges;

use App\Models\Step;
use Livewire\Component;
use App\Models\Challenge;
use Livewire\WithPagination;

class ChallengesComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $title,
        $instructions,
        $delivery_date,
        $challengeId,
        $stepId,
        $points,
        $required_points,
        $reminder_message,
        $reminder_message_date,
        $reminder_message_mean,
        $congratulation_message,
        $congratulation_message_date,
        $congratulation_message_mean;


    public $searchName;

    public function mount($id)
    {
        $this->stepId = $id;
    }

    public function render()
    {
        $challenges = Challenge::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
            ->where('step_id', '=', $this->stepId)
            ->paginate(6);

        $firstItem = $challenges->firstItem();
        $lastItem = $challenges->lastItem();
        $step = Step::find($this->stepId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$challenges->total()} registros";

        return view('livewire.admin.challenges.challenges-component', [
            'challenges' => $challenges,
            'paginationText' => $paginationText,
            'step' => $step
        ]);
    }

    public function show($id)
    {
        $this->challengeId = $id;

        $challenge = Challenge::find($id);
        $this->title = $challenge->title;
        $this->instructions = $challenge->instructions;
        $this->delivery_date = $challenge->delivery_date;
        $this->stepId = $challenge->step_id;
        $this->points = $challenge->points;
        $this->required_points = $challenge->required_points;
        $this->reminder_message = $challenge->reminder_message;
        $this->reminder_message_date = $challenge->reminder_message_date;
        $this->reminder_message_mean = $challenge->reminder_message_mean;
        $this->congratulation_message = $challenge->congratulation_message;
        $this->congratulation_message_date = $challenge->congratulation_message_date;
        $this->congratulation_message_mean = $challenge->congratulation_message_mean;
    }

    public function store()
    {
        $this->validate([
            'title' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingChallenge = Challenge::where('title', $value)
                        ->where('step_id', $this->stepId)
                        ->where('id', '!=', $this->challengeId) //
                        ->first();
                    if ($existingChallenge) {
                        $fail('El nombre del reto ya existe en este paso.');
                    }
                },
            ],
            'instructions' => 'required',
            'delivery_date' => 'required|date',//|after_or_equal:today
            'points' => 'nullable|numeric|min:1',
            'required_points' => 'nullable|numeric|min:1',
            'reminder_message' => 'nullable|string',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable|string',
            'congratulation_message' => 'nullable|string',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable|string',
        ], [], [
            'title' => 'titulo',
            'instructions' => 'instruccion',
            'delivery_date' => 'fecha de entrega',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $challenge = new Challenge();
        $challenge->title = $this->title;
        $challenge->instructions = $this->instructions;
        $challenge->delivery_date = $this->delivery_date;
        $challenge->points = $this->points;
        $challenge->required_points = $this->required_points ?: null;
        $challenge->reminder_message = $this->reminder_message;
        $challenge->reminder_message_date = $this->reminder_message_date ?: null;
        $challenge->reminder_message_mean = $this->reminder_message_mean;
        $challenge->congratulation_message = $this->congratulation_message;
        $challenge->congratulation_message_date = $this->congratulation_message_date ?: null;
        $challenge->congratulation_message_mean = $this->congratulation_message_mean;
        $challenge->step_id = $this->stepId;
        $challenge->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Retos y entregables creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->challengeId = $id;

        $challenge = Challenge::find($id);
        $this->title = $challenge->title;
        $this->instructions = $challenge->instructions;
        $this->delivery_date = $challenge->delivery_date;
        $this->points = $challenge->points;
        $this->required_points = $challenge->required_points;
        $this->reminder_message = $challenge->reminder_message;
        $this->reminder_message_date = $challenge->reminder_message_date;
        $this->reminder_message_mean = $challenge->reminder_message_mean;
        $this->congratulation_message = $challenge->congratulation_message;
        $this->congratulation_message_date = $challenge->congratulation_message_date;
        $this->congratulation_message_mean = $challenge->congratulation_message_mean;
    }

    public function update()
    {

        $this->validate([
            'title' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingChallenge = Challenge::where('title', $value)
                        ->where('step_id', $this->stepId)
                        ->where('id', '!=', $this->challengeId) //
                        ->first();
                    if ($existingChallenge) {
                        $fail('El nombre del reto ya existe en este paso.');
                    }
                },
            ],
            'instructions' => 'required',
            'delivery_date' => 'required|date',//|after_or_equal:today
            'points' => 'nullable|numeric|min:1',
            'required_points' => 'nullable|numeric|min:1',
            'reminder_message' => 'nullable|string',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable|string',
            'congratulation_message' => 'nullable|string',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable|string',
        ], [], [
            'title' => 'nombre',
            'instructions' => 'descripción',
            'delivery_date' => 'fecha de entrega',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $challenge = Challenge::find($this->challengeId);
        $challenge->title = $this->title;
        $challenge->instructions = $this->instructions;
        $challenge->delivery_date = $this->delivery_date;
        $challenge->points = $this->points;
        $challenge->required_points = $this->required_points ?: null;
        $challenge->reminder_message = $this->reminder_message;
        $challenge->reminder_message_date = $this->reminder_message_date ?: null;
        $challenge->reminder_message_mean = $this->reminder_message_mean;
        $challenge->congratulation_message = $this->congratulation_message;
        $challenge->congratulation_message_date = $this->congratulation_message_date ?: null;
        $challenge->congratulation_message_mean = $this->congratulation_message_mean;
        $challenge->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Retos y entregables actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->challengeId = $id;
    }

    public function destroy()
    {
        $challenge = Challenge::find($this->challengeId);
        $challenge->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Retos y entregables eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->instructions = '';
        $this->delivery_date = '';
        $this->challengeId = '';
        $this->points = '';
        $this->required_points = '';
        $this->reminder_message = '';
        $this->reminder_message_date = '';
        $this->reminder_message_mean = '';
        $this->congratulation_message = '';
        $this->congratulation_message_date = '';
        $this->congratulation_message_mean = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
