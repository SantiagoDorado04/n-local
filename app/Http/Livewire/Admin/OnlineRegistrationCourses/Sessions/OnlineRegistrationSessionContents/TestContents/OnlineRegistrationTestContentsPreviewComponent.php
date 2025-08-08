<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents;

use App\Contact;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationTestItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OnlineRegistrationTestContentsPreviewComponent extends Component
{

    public $test_id, $test;
    public $items, $choices;
    public $cant = 0, $count = 1;
    public $contactId;
    public $responses = [];
    public $input, $message = '';

    public $score = 0;
    public $showResults = false;
    public $testPassed = false;

    public function mount($id)
    {
        $this->test_id = $id;
        $this->test = OnlineRegistrationTestContent::find($id);
        $this->items = OnlineRegistrationTestItem::where('or_test_id', '=', $id)
            ->get();
        $this->choices = OnlineRegistrationTestChoice::whereIn('or_item_id', $this->items->pluck('id'))->get();

        $this->cant = count($this->items);

        if (auth()->check() && auth()->user()->role_id == 7) {
            $this->count = 2;
            $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
            $this->contactId = $contact->id;
        }
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-contents-preview-component');
    }

    public function nextItem()
    {
        if ($this->count <= $this->cant + 1) { // ✅ Evita sobrepasar el total de preguntas
            // ✅ Validar solo si estamos en una pregunta (ignorar instrucciones)
            if ($this->count > 1) {
                $itemIndex = $this->count - 2; // 🔥 Ajustar el índice correctamente

                if (isset($this->items[$itemIndex])) {
                    $item = $this->items[$itemIndex];
                    $responseKey = "responses.item_{$item->id}";
                    $responseValue = $this->responses["item_{$item->id}"] ?? null;

                    if (empty($responseValue)) {
                        $this->addError($responseKey, 'Debes seleccionar una opción.');
                        return; // ❌ No avanza si no hay respuesta
                    }
                }
            }

            // 🔥 Limpiar errores antes de avanzar
            $this->resetErrorBag();

            // ✅ Avanzar a la siguiente pregunta
            $this->count++;

            // 🔄 Forzar actualización del componente para asegurar renderizado
            $this->emitSelf('refreshComponent');
        }
    }

    public function previousItem()
    {
        $this->count--;
    }

    private function updateProgress()
    {
        if ($this->count == 1) {
            $this->count++;
        }
    }

    public function submitTest()
    {
        $correctAnswers = 0;
        $totalItems = count($this->items);

        foreach ($this->items as $item) {
            $selectedChoiceId = $this->responses["item_{$item->id}"] ?? null;

            if ($selectedChoiceId) {
                $selectedChoice = $item->choices->where('id', $selectedChoiceId)->first();
                if ($selectedChoice && $selectedChoice->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        // ✅ Cálculo del porcentaje
        $this->score = ($correctAnswers / $totalItems) * 100;
        $this->testPassed = $this->score >= $this->test->percentage;
        $this->showResults = true;

        // ✅ Avanzar al resultado final
        $this->count++;
    }

    public function retryTest()
    {
        // 🔄 Reiniciar respuestas y volver al inicio
        $this->responses = [];
        $this->count = 1;
        $this->score = 0;
        $this->showResults = false;
        $this->testPassed = false;

        // 🔄 Forzar actualización del componente
        $this->emitSelf('refreshComponent');
    }
}
