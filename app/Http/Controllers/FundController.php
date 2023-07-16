<?php

namespace App\Http\Controllers;

use App\Models\FundManager;
use Canoe\Fund\Exception\NotFoundFundExecption;
use Canoe\Fund\FundService;
use Canoe\Fund\Http\AliasFundRequest;
use Canoe\Fund\Http\FundManagerRequest;
use Canoe\Fund\Http\FundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FundController extends Controller {
    public function index(Request $request) {
        $validator = $this->getValidator($request->query());
        if ($validator->fails()) {
            return response()
                ->json(['status' => 'error', 'message' => $validator->getMessageBag()], 400);
        }

        return response()->json([ 'status' => 'success', 'funds' => FundService::listFunds($request->query()) ]);
    }

    public function update(Request $request, string $id) {
        $validator = $this->getValidator($request->all());
        if ($validator->fails()) {
            return response()
                ->json(['status' => 'error', 'message' => $validator->getMessageBag()], 400);
        }

        try {
            FundService::updateFund($id, $this->buildFundRequest($request->all()));
            return response()->json([ 'status' => 'success' ]);
        } catch (NotFoundFundExecption $e) {
            return response('Not Found', 404);
        }
    }

    public function store(Request $request): mixed {
        $validator = $this->gatValidatorInStore($request->all());
        if ($validator->fails()) {
            return response()
                ->json(['status' => 'error', 'message' => $validator->getMessageBag()], 400);
        }

        $fund_request = $this->buildFundRequest($request->all());
        $fund = FundService::createFund($fund_request);

        return response()->json([ 'status' => 'success', 'fund' => $fund ]);
    }

    public function listDuplicated() {
        return response()->json([ 'status' => 'success', 'funds' => FundService::getDuplicatedFunds() ]);
    }

    private function buildFundRequest(array $params): FundRequest {
        $fund_request = new FundRequest();
        
        if (isset($params['name'])) $fund_request->name = $params['name'];
        if (isset($params['start_year'])) $fund_request->start_year = $params['start_year'];
        if (isset($params['fund_manager']['name'])) {
            $fund_manager_request = new FundManagerRequest();
            $fund_manager_request->name = $params['fund_manager']['name'];
            $fund_request->fund_manager = $fund_manager_request;
        }
        if (isset($params['alias_funds'])) {
            $fund_request->alias_funds = array_map(function ($alias_fund) {
                $alias_fund_request = new AliasFundRequest();
                $alias_fund_request->name = $alias_fund['name'];
                return $alias_fund_request;
            }, $params['alias_funds']);
        }

        return $fund_request;
    }

    private function getValidator(array $params): mixed {
        return Validator::make($params, [
            'year' => 'numeric|max:'.date("Y").'|min:1900',
            'start_year' => 'numeric|max:'.date("Y").'|min:1900',
            'name' => 'string|max:50',
            'fund_manager' => 'string|max:50',
        ]);
    }

    private function gatValidatorInStore(array $params) {
        return Validator::make($params, [
            'start_year' => 'required|numeric|max:'.date("Y").'|min:1900',
            'name' => 'required|string|max:50',
            'fund_manager.name' => 'required|string|max:50',
            'alias_funds.*.name' => 'string|max:50',
        ]);
    }
}
