<?php

namespace Canoe\Fund\Repository;

use App\Models\FundManager;
use Illuminate\Support\Facades\Log;

class FundManagerRepository {
    public static function findOrCreate(string $name): FundManager {
        $fund_manager = FundManager::where('name', 'like', $name)->first();

        if (isset($fund_manager)) return $fund_manager;

        return self::create($name);
    }

    private static function create(string $name): FundManager {
        $fund_manager = new FundManager();
        $fund_manager->name = $name;
        $fund_manager->save();

        return $fund_manager;
    }
}
