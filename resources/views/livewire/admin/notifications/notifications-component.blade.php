<div>
    <style>
        .notification-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        .notification-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .notification-content .message {
            flex: 1;
            font-size: 16px;
        }

        .notification-content .time {
            margin-right: 20px;
            font-size: 14px;
            color: #888;
        }

        .notification-content .mark-read button {
            margin-left: 10px;
        }

        .notification-panel:last-child {
            border-bottom: none;
        }

        .panel-body {
            padding: 0 15px;
        }

        .panel-heading {
            background-color: #f5f5f5;
            font-size: 18px;
            padding: 10px 15px;
            font-weight: bold;
        }

        .message-success {
            padding: 12px;
            background-color: #e8ffee;
            border-left: 5px solid #38d75d;
        }

        .message-info {
            padding: 12px;
            background-color: #e6fcff;
            border-left: 5px solid #17a2b8;
        }
    </style>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="max-height: 575px; overflow-y: auto;">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="container">
                                    <h4 style="padding: 20px; background-color: #FE9941; color: white;"">Notificaciones
                                    </h4>

                                    @foreach ($notifications as $date => $groupedNotifications)
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h6>{{ $date }}</h6>
                                            </div>
                                            <div class="panel-body">
                                                @foreach ($groupedNotifications as $notification)
                                                    <div class="panel panel-default"
                                                        style="border: 0px; margin-bottom: 8px">
                                                        <div class="notification-panel"
                                                            style="border-bottom: 0px solid #ffffff; padding: 5px 0;">
                                                            <div class="notification-content">
                                                                <div
                                                                    class="message {{ $notification->read == 1 ? 'message-success' : 'message-info' }}">
                                                                    <h5>{!! $notification->message !!}</h5>
                                                                    <h6>{{ $notification->created_at->format('H:i') }}
                                                                    </h6>
                                                                </div>
                                                                <div class="time" style="margin-left:20px">
                                                                    @if ($notification->read == 1)
                                                                    @else
                                                                        <a wire:click="markAsRead({{ $notification->id }})"
                                                                            style="text-decoration: none">
                                                                            <h1>
                                                                                <i class="voyager-check"></i>
                                                                            </h1>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
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
    </div>
</div>
