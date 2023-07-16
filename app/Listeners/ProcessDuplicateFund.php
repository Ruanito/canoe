<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use Illuminate\Support\Facades\Log;

class ProcessDuplicateFund
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DuplicateFundWarning $event): void
    {
        Log::debug('Process DuplicateFundWarning FundId=' . $event->fund->id);
        Log::debug('TODO');
    }
}
