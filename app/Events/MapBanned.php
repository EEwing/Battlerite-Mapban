<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MapBanned implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $map;
    public $mapBan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($map, $mapBan)
    {
        $this->map = $map;
        $this->mapBan = $mapBan;

        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['map_banned_'.$this->mapBan->id];
    }
}