<?php
namespace App\Events;


use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $chat;


    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }


    public function broadcastOn()
    {
        $i=$this->chat->group_id;
        return new PresenceChannel('send'.$i);
    }
}