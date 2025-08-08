<div>
    <style>
.ch-masonry {
    column-count: 3;
    column-gap: 15px;

}

@media only screen and (max-width: 768px) {
    .ch-masonry {
        column-count: 2;
    }
}

@media only screen and (max-width: 371px) {
    .ch-masonry {
        column-count: 1;
    }
}

.ch-masonry__item {
    display: inline-block;
    background: #fff;
    width: 100%;
    margin-bottom: 15px;
    box-sizing: border-box;
    box-shadow: 2px 2px 4px 0 rgb(236, 236, 236);
}

.ch-masonry__item img {
  width: 100%;
  max-width: 100%;
}
        .sidebar-wrapper {
            background: #F5B029;
            right: 0;
            height: 100%;
            min-height: 100%;
            color: #fff;
        }

        .sidebar-wrapper a {
            color: #fff;
        }

        .sidebar-wrapper .profile-container {
            padding: 30px;
            background: #F5B029;
            text-align: center;
            color: #fff;
        }

        .sidebar-wrapper .name {
            font-size: 32px;
            font-weight: 900;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .sidebar-wrapper .tagline {
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
            font-weight: 400;
            margin-top: 0;
            margin-bottom: 0;
        }

        .sidebar-wrapper .profile {
            width: 100px;
            height: 100px;
            border-radius: 50px;
            margin-bottom: 15px;
            background-color: #fff
        }

        .sidebar-wrapper .contact-list .fa {
            margin-right: 5px;
            font-size: 18px;
            vertical-align: middle;
        }

        .sidebar-wrapper .contact-list li {
            margin-bottom: 15px;
        }

        .sidebar-wrapper .contact-list li:last-child {
            margin-bottom: 0;
        }

        .sidebar-wrapper .contact-list .email .fa {
            font-size: 14px;
        }

        .sidebar-wrapper .container-block {
            padding: 30px;
        }

        .sidebar-wrapper .container-block-title {
            text-transform: uppercase;
            font-size: 16px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .sidebar-wrapper .degree {
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .sidebar-wrapper .education-container .item {
            margin-bottom: 15px;
        }

        .sidebar-wrapper .education-container .item:last-child {
            margin-bottom: 0;
        }

        .sidebar-wrapper .education-container .meta {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
            margin-bottom: 0px;
            margin-top: 0;
        }

        .sidebar-wrapper .education-container .time {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
            margin-bottom: 0px;
        }

        .sidebar-wrapper .languages-container .lang-desc {
            color: rgba(255, 255, 255, 0.6);
        }

        .sidebar-wrapper .languages-list {
            margin-bottom: 0;
        }

        .sidebar-wrapper .languages-list li {
            margin-bottom: 10px;
        }

        .sidebar-wrapper .languages-list li:last-child {
            margin-bottom: 0;
        }

        .sidebar-wrapper .interests-list {
            margin-bottom: 0;
        }

        .sidebar-wrapper .interests-list li {
            margin-bottom: 10px;
        }

        .sidebar-wrapper .interests-list li:last-child {
            margin-bottom: 0;
        }


        .skillset .item {
            --margin-bottom: 15px;
            overflow: hidden;
        }

        .skillset .level-title {
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 12px;
        }

        .skillset .progress-bar {
            background: #F5B029;
        }
    </style>


    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Perfíl de cliente</li>
        </ol>
    @endsection

    @section('page_title', 'Perfíl de cliente | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-company"></i> Perfíl de cliente
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="margin: 10px; padding:10px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-3">
                                <div class="panel panel-bordered">
                                    <div class="panel-body" style="margin: 5px; padding:5px">
                                        <div class="sidebar-wrapper">
                                            <div class="profile-container">
                                                <img class="profile"
                                                    src="{{ url('/storage/users/January2023/9Vn6v8Nxb4G6OmU2ethY.png') }}"
                                                    alt="" />
                                                <h1 class="name">{{ $contact->name }}</h1>
                                                <h4 class="tagline"><small style="color:#fff">NIT.</small>
                                                    {{ $contact->nit }}</h4>
                                            </div>
                                            <!--//profile-container-->

                                            <div class="contact-container container-block" style="background-color: #F5B029">
                                                <ul class="list-unstyled contact-list">
                                                    
                                                    <li class="email">
                                                        @isset($contact->email)
                                                            <a href="mailto:{{ $contact->email }}" style="text-decoration:none" target="_blank">
                                                                <i class="fa fa-envelope"></i>
                                                                {{ $contact->email }}
                                                            </a>
                                                        @endisset
                                                    </li>

                                                    <li class="phone">
                                                        @isset($contact->phone)
                                                            <a href="tel:{{ $contact->phone }}" style="text-decoration:none" target="_blank">
                                                                <i class="fa fa-phone"></i>
                                                                {{ $contact->phone }}
                                                            </a>
                                                        @endisset
                                                    </li>

                                                    <li class="linkedin">
                                                        @isset($contact->whatsapp)
                                                            <a href="https://wa.me/{{ $contact->whatsapp }}" style="text-decoration:none" target="_blank">
                                                                <i class="fa fa-whatsapp"></i>
                                                                {{ $contact->whatsapp }}
                                                            </a>
                                                        @endisset
                                                    </li>

                                                    <li class="github">
                                                        @isset($contact->website)
                                                            <a href="{{ $contact->website }}" style="text-decoration:none" target="_blank">
                                                                <i class="fa fa-link"></i>
                                                                {{ $contact->website }}
                                                            </a>
                                                        @endisset
                                                    </li>

                                                </ul>
                                            </div>
                                            <!--//contact-container-->
                                            <div class="education-container container-block" style="background-color: #F5B029">
                                                <h2 class="container-block-title">Persona de contacto</h2>
                                                <div class="item">
                                                    <h4 class="degree">{{ $contact->contact_person_name }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="panel panel-bordered">
                                    <div class="panel-body" style="margin: 5px; padding:5px">
                                        <div class="row no-margin-bottom">
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered" style="background-color: #F5B029">
                                                    <div class="panel-body" style="margin: 5px; padding:5px">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-md-12">
                                                                <div class="panel panel-bordered">
                                                                    <div class="panel-body"
                                                                        style="margin: 5px; padding:5px">
                                                                        {{-- <div class="row no-margin-bottom">
                                                                            @if (count($questions) > 0)
                                                                                @foreach ($questions as $question)
                                                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                                                    <div class="panel panel-bordered">
                                                                                        <div class="panel-heading text-center" style="padding:15px; background-color:#CC9CE5; color:#fff" >
                                                                                            <h5 style="margin-bottom:0px">{{ $question->question }}</h5>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            {{ $answers->{'question_'.$question->id} }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            @endif

                                                                            @if ($sAnswers != '')
                                                                            @foreach ($sQuestions as $question)
                                                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                                                    <div class="panel panel-bordered">
                                                                                        <div class="panel-heading text-center" style="padding:15px; background-color:#CC9CE5; color:#fff" >
                                                                                            <h5 style="margin-bottom:0px">{{ $question->question }}</h5>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            {{ $sAnswers->{'question_'.$question->id} }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div> --}}
                                                                        <div class="ch-masonry">
                                                                            @if (count($questions) > 0)
                                                                                @foreach ($questions as $question)
                                                                                @if ($answers != '')
                                                                                <div class="ch-masonry__item">
                                                                                
                                                                                    {{-- <div class="panel panel-bordered"> --}}
                                                                                        <div class="panel-heading text-center" style="padding:15px; background-color:#F5B029; color:#fff" >
                                                                                            <h5 style="margin-bottom:0px">{{ $question->question }}</h5>
                                                                                        </div>
                                                                                        <div class="panel-body" style="padding: 15px">
                                                                                            {{ $answers->{'question_'.$question->id} }}
                                                                                        </div>
                                                                                   {{--  </div> --}}
                                                                                
                                                                                </div>
                                                                                @endif
                                                                                @endforeach
                                                                            @endif
                                                                            @if ($sAnswers != '')
                                                                            @foreach ($sQuestions as $question)
                                                                            <div class="ch-masonry__item">
                                                                                    {{-- <div class="panel panel-bordered"> --}}
                                                                                        <div class="panel-heading text-center" style="padding:15px; background-color:#F5B029; color:#fff" >
                                                                                            <h5 style="margin-bottom:0px">{{ $question->question }}</h5>
                                                                                        </div>
                                                                                        <div class="panel-body" style="padding: 15px">
                                                                                            {{ $sAnswers->{'question_'.$question->id} }}
                                                                                        </div>
                                                                                    {{-- </div> --}}
                                                                                </div>
                                                                                @endforeach
                                                                            @endif
                                                                
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('javascript')
            <script src="https://masonry.desandro.com/masonry.pkgd.js"></script>
            <script>
                // external js: masonry.pkgd.js

                $('.grid').masonry({
                    itemSelector: '.grid-item',
                    columnWidth: '.grid-sizer',
                    percentPosition: true
                });
            </script>
        @endpush
    </div>
