<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use App\Events\FundCreated;
use Canoe\Fund\Repository\FundRepository;
use Illuminate\Support\Facades\Log;

class VerifyDuplicatedFund
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
    public function handle(FundCreated $event): void
    {
        Log::debug('Start VerifyDuplicatedFund');
        Log::debug('Fund id='.$event->fund->id);
        $duplicated_funds = FundRepository::findListByAliasNameAndManagerIdAndFundId(
            $event->fund->name, 
            $event->fund->fund_manager_id,
            $event->fund->id
        );
        if (!empty($duplicated_funds)) DuplicateFundWarning::dispatch($event->fund);

        Log::debug('Duplicated funds: ' . json_encode($duplicated_funds));   
    }
}
