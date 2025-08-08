<?php

namespace App\Http\Livewire\Admin\Notifications;

use Carbon\Carbon;
use App\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsComponent extends Component
{
    use WithPagination;

    public $perPage = 10; 

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->paginate($this->perPage)
            ->groupBy(function ($notification) {
                $createdAt = Carbon::parse($notification->created_at);
                if ($createdAt->isToday()) {
                    return 'Hoy';
                } elseif ($createdAt->isYesterday()) {
                    return 'Ayer';
                } else {
                    return $createdAt->format('d M Y'); 
                }
            });
    
        return view('livewire.admin.notifications.notifications-component', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['read' => 1]); 
        }
    }
}