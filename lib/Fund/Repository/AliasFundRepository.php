<?php

namespace Canoe\Fund\Repository;

use App\Models\AliasFund;
use Canoe\Fund\Http\AliasFundRequest;

class AliasFundRepository {
    public static function create(AliasFundRequest $alias_fund_request, int $fund_id): AliasFund {
        $alias_fund = new AliasFund();

        $alias_fund->name = $alias_fund_request->name;
        $alias_fund->fund_id = $fund_id;
        $alias_fund->save();

        return $alias_fund;
    }
}
