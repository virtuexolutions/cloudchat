<?php
namespace App\Helpers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Pusher implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $message;
    public $channels;
    public $event;

    public function __construct($message="",$data=[],$channels=[],$event="my-event")
    {
        $this->message = $message;
        $this->data = $data;
        $this->channels = $channels;
        $this->event = $event;
    }

    public function broadcastAs()
    {
        return $this->event;
    }
    public function broadcastOn()
    {
        return $this->channels;
    }
}