<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class PusherEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $chat;
  public $message;
  public $target_id;
  public $response;

  public function __construct($message,$chat,$target_id,$response)
  {
      $this->chat = $chat;
      $this->message = $message;
      $this->target_id = $target_id;
      $this->response = $response;
  }
  public function broadcastOn()
  {
      return ["my-channel-".$this->chat];
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
} 