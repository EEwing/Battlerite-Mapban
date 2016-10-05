<?php

namespace App\Listeners;

use App\Events\MapBanned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MapBannedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MapBanned  $event
     * @return void
     */
    public function handle(MapBanned $event)
    {
        //
    }
}
