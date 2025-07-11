<?php
namespace App\Events;

// namespace App\Events;

// use Illuminate\Broadcasting\Channel;
// use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// use Illuminate\Foundation\Events\Dispatchable;
// use Illuminate\Queue\SerializesModels;
// use App\Models\Task;
// use App\Models\Notification;

// class TaskCreated
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public Task $task;
//     public Notification $notification;


//     public function __construct(Task $task, Notification $notification)
//     {
//         $this->task = $task;
//         $this->notification = $notification;
//     }

    

//     public function broadcastOn(): array
//     {
//         return [
//             new PrivateChannel('user.' . $this->task->user_id),
//         ];
//     }
    
//      public function broadcastAs(): string
//     {
//         return 'task.created';
//     }

   
//     public function broadcastWith(): array
//     {
//         return [
//             'task' => $this->task,
//             'notification' => $this->notification,
//         ];
//     }
// } -->

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;
use App\Models\Notification;

class TaskCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Task $task;
    public Notification $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task, Notification $notification)
    {
        $this->task = $task;
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->task->user_id),
        ];
    }
    
    public function broadcastAs(): string
    {
        return 'task.created';
    }

    /**
     * The data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'task' => $this->task,
            'notification' => $this->notification,
        ];
    }
}