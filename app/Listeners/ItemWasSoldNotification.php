<?php

namespace App\Listeners;

use App\Events\ItemWasSold;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ItemWasSoldNotification
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
     * @param  \App\Events\ItemWasSold  $event
     * @return void
     */
    public function handle(ItemWasSold $event)
    {
        // TODO:: inform all
    }
}
