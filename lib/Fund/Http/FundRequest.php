<?php

namespace Canoe\Fund\Http;

class FundRequest {
    public string|null $name;
    public int|null $start_year;
    public FundManagerRequest|null $fund_manager;
    public array|null $alias_funds;
}
