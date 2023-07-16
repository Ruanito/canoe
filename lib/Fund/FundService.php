<?php

namespace Canoe\Fund;

use App\Events\FundCreated;
use Canoe\Fund\Http\FundRequest;
use Canoe\Fund\Repository\AliasFundRepository;
use Canoe\Fund\Repository\FundManagerRepository;
use Canoe\Fund\Repository\FundRepository;
use Illuminate\Support\Facades\DB;

class FundService {
    public static function listFunds(array $params) {
        return FundRepository::list($params);
    }

    public static function updateFund(string $id, FundRequest $fund_request) {
        FundRepository::update($id, $fund_request);
    }

    public static function createFund(FundRequest $fund_request) {
        DB::beginTransaction();
        $fund_manager = FundManagerRepository::findOrCreate($fund_request->fund_manager->name);

        $fund = FundRepository::create($fund_request, $fund_manager->id);
        foreach($fund_request->alias_funds as $alias_fund) {
            AliasFundRepository::create($alias_fund, $fund->id);
        }
        DB::commit();

        FundCreated::dispatch($fund);

        return $fund;
    }

    public static function getDuplicatedFunds(): array {
        return FundRepository::findDuplicatedFunds();
    }
}
