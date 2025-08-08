<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostulatesListExport implements FromView
{
    use Exportable;

    protected  $postulates, $formStage, $answers,  $stage;

    public function __construct($postulates,$formStage, $answers, $stage)
    {
        $this->postulates = $postulates;
        $this->formStage = $formStage;
        $this->answers = $answers;
        $this->stage = $stage;
    }

    public function view(): View
    {
        return view('exports.postulates', [
            'postulates' => $this->postulates,
            'formStage' => $this->formStage,
            'answers' => $this->answers,
            'stage' => $this->stage
        ]);
    }
    
}
