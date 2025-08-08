<?php

namespace App\Http\Livewire\Admin\OnlineRegistrations;

use App\Models\OnlineRegistrationChannel;
use App\Models\OnlineRegistrationExternalExecution;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineRegistrationExternalExecutionsComponent extends Component
{
    use WithPagination;

    public function render()
    {
        $executions = OnlineRegistrationExternalExecution::query()
            ->orderBy('id', 'desc')
            ->paginate(25);

        $firstItem = $executions->firstItem();
        $lastItem = $executions->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$executions->total()} registros";

        return view('livewire.admin.online-registrations.online-registration-external-executions-component', [
            'executions' => $executions,
            'paginationText' => $paginationText,
        ]);
    }
}