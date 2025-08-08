<?php

namespace App\Http\Livewire\Admin\Reports\TrainingReport;

use App\Models\OnlineRegistration;
use App\Models\ContactsCourseRegistrationForm;
use Livewire\Component;
use Carbon\Carbon;

class TrainingReportComponent extends Component
{
    public $onlineRegistration, $online_registration_id;
    public $capacitados;
    public $month;
    public $year;
    public $currentMonth;

    public function mount($id){
        
        $this->online_registration_id = $id;
        $this->onlineRegistration = OnlineRegistration::find($this->online_registration_id);
        $this->currentMonth = Carbon::now()->month;

    }

    public function render()
    {
        $this->capacitados = Contact::whereHas('contactsCourseRegistrationForms.courseRegistrationForm', function ($query) {
            $query->where('online_registration_id', $this->online_registration_id);
        })->get();
            
        return view('livewire.admin.reports.training-report.training-report-component', [
            'capacitados' => $this->capacitados
        ]);
    }
}
