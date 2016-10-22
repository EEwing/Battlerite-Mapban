<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TeamReady implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $team;
    public $mapban;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($team, $mapban)
    {
        $this->team = $team;
        $this->mapban = $mapban;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['map_ban_'.$this->mapban->id];
    }
}
