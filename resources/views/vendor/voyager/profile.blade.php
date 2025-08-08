@extends('voyager::master')

@section('css')
    <style>
        .user-email {
            font-size: .85rem;
            margin-bottom: 1.5em;
        }
    </style>
@stop

@section('content')
    <div
        style="background-size:cover; background-image: url({{ Voyager::image(Voyager::setting('admin.bg_image'), voyager_asset('/images/bg.jpg')) }}); background-position: center center;position:absolute; top:0; left:0; width:100%; height:300px;">
    </div>
    <div style="height:160px; display:block; width:100%"></div>
    <div style="position:relative; z-index:9; text-align:center;">
        <img src="@if (!filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL)) {{ Voyager::image(Auth::user()->avatar) }}@else{{ Auth::user()->avatar }} @endif"
            class="avatar" style="border-radius:50%; width:150px; height:150px; border:5px solid #fff;"
            alt="{{ Auth::user()->name }} avatar">
        <h4>{{ ucwords(Auth::user()->name) }}</h4>
        <div class="user-email text-muted">{{ ucwords(Auth::user()->email) }}</div>
        <p>{{ Auth::user()->bio }}</p>
        @if ($route != '')
            <a href="{{ $route }}" class="btn btn-primary">{{ __('voyager::profile.edit') }}</a>
        @endif
    </div>

    {{-- <div class="row " style="margin-top:20px">
        <div class="col-lg-12">
            <div class="page-content browse container-fluid">
                <div class="row no-margin-bottom">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row no-margin-bottom">
                                    @php
                                        $memberships = \App\Membership::all();
                                    @endphp
                                    @foreach ($memberships as $membership)
                                        <div class="col-md-3">
                                            <div class="panel panel-bordered">
                                                <div class="panel-heading text-center"
                                                    style="padding:20px; background-color:#A09CE2;color:#fff;margin-bottom:-1px">
                                                    <h5 style="margin-bottom:0px">{{ $membership->name }}</h5>
                                                </div>
                                                <div class="panel-body"
                                                    style=" border: 1px solid #A09CE2;margin-top:0px;padding:5px">
                                                    <div class="row no-margin-bottom">
                                                        <div class="col-md-12">
                                                            <p>
                                                                {!! $membership->description !!}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12 text-center">
                                                            <button class="btn " style="background-color:#E89CE1;color:#fff;">Aquirir Membresia</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@stop
