<div>
    @include('livewire.admin.contacts-forms.modals.info')
    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>Formularios asignados</li>
    </ol>
    @endsection

    @section('page_title', 'Formularios asignados | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-company"></i>&nbsp;Formularios asignados
        </h1>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="thwidth"><small>Formulario</small></th>
                                                <th class="thwidth"><small>Fecha de asignación</small></th>
                                                <th class="thwidth"><small>Estado</small></th>
                                                <th class="actions dt-not-orderable thwidth">
                                                    <small>{{ __('voyager::generic.actions') }}</small>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($contact->assignedForms as $form)
                                                <tr>
                                                    <td>{{ $form->commercialFormAction->commercialForm->name }}</td>
                                                    <td>{{ $form->created_at }}</td>
                                                    <td>
                                                        @php
                                                            $commercialFormAction = $form->commercialFormAction;
                                                            $commercialForm = $commercialFormAction->commercialForm;
                                                    
                                                            $tableName = 'answers_form_' . $commercialForm->id;
                                                    
                                                            $existingAnswer = DB::table($tableName)
                                                                ->where('contact_id', $form->contact_id)
                                                                ->where('commercial_action_id', '=', $commercialFormAction->commercial_action_id)
                                                                ->first();
                                                        @endphp
                                                    
                                                        @empty($existingAnswer)
                                                            <span class="label label-warning">Sin diligenciar</span>
                                                        @else
                                                            <span class="label label-success">Diligenciado</span>
                                                        @endempty
                                                    </td>
                                                    <td>
                                                        @empty($existingAnswer)
                                                            <a href="{{ url('') . '/form/' . $form->commercialFormAction->token }}" 
                                                                class="btn btn-primary sm-b" style="text-decoration: none" target="_blank">
                                                                <i class="fa fa-check-square"></i>
                                                                &nbsp;Diligenciar
                                                            </a>
                                                        @else
                                                            <button class="btn btn-success sm-b" data-toggle="modal" data-target="#info-modal" wire:click="getResult({{ $form->id }})">
                                                                <i class="fa fa-calendar-check-o"></i>&nbsp;Respuestas
                                                            </button>

                                                            <a href="{{ route('contacts.my-forms.announcements',['form'=>$commercialForm->id,'action'=>$commercialFormAction->commercial_action_id]) }}" 
                                                                class="btn btn-primary sm-b" style="text-decoration: none">
                                                                <i class="fa fa-check-square"></i>
                                                                &nbsp;Convocatorias
                                                            </a>
                                                        @endempty
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">No se encontraron formularios asignados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

