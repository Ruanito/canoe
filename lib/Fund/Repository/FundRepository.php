<?php

namespace Canoe\Fund\Repository;

use App\Models\Fund;
use Canoe\Fund\Exception\NotFoundFundExecption;
use Canoe\Fund\Http\FundRequest;
use Illuminate\Support\Facades\DB;

class FundRepository {
    public static function list(array $params) {
        $funds =  DB::table('funds')
            ->select('funds.id', 'funds.name', 'funds.start_year', 'fund_managers.name as fund_manager')
            ->join('fund_managers', 'funds.fund_manager_id', '=', 'fund_managers.id');

        if (isset( $params['fund_manager'])) {
            $funds = $funds->where('fund_managers.name', 'like', $params['fund_manager']);
        }
        
        if (isset($params['year'])) {
            $funds = $funds->where('start_year', '=', $params['year']);
        }

        if (isset($params['name'])) {
            $funds = $funds->where('funds.name', '=', $params['name']);
        }

        return $funds->get();
    }

    public static function update(string $id, FundRequest $fund_requst): void {
        $fund = Fund::find($id);

        if (is_null($fund)) 
            throw new NotFoundFundExecption();

        if (isset($fund_requst->name)) $fund->name = $fund_requst->name;
        if (isset($fund_requst->start_year)) $fund->start_year = $fund_requst->start_year;

        $fund->save();
    }

    public static function create(FundRequest $fund_requst, int $fund_manager_id): Fund {
        $fund = new Fund();

        $fund->name = $fund_requst->name;
        $fund->start_year = $fund_requst->start_year;
        $fund->fund_manager_id = $fund_manager_id;
        $fund->save();

        return $fund;
    }

    public static function findDuplicatedFunds(): array {
        $query = "SELECT f.id AS fund_id, f.name AS fund_name, fm.name AS fund_manager FROM funds f
            INNER JOIN alias_funds af ON af.name = f.name AND f.id != af.fund_id
            INNER JOIN fund_managers fm ON fm.id = f.fund_manager_id";

        return DB::select($query);
    }

    public static function findListByAliasNameAndManagerIdAndFundId(string $alias_name, int $fund_manager_id, int $fund_id): array {
        $query = "SELECT F.* FROM funds F
            INNER JOIN alias_funds af ON F.id = af.fund_id
            WHERE F.id != :fund_id AND F.fund_manager_id = :fund_manager_id AND af.name LIKE :alias_name";
            
        return DB::select($query, [
            'alias_name' => $alias_name,
            'fund_manager_id' => $fund_manager_id,
            'fund_id' => $fund_id,
        ]);
    }
}
