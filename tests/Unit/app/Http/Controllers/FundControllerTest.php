<?php

namespace Tests\Unit\App\Http\Controller;

use App\Models\Fund;
use App\Models\FundManager;
use Tests\TestCase;

class FundControllerTest extends TestCase {

    private function createFund(): Fund {
        $fund_manager = new FundManager();
        $fund_manager->name = fake()->name();
        $fund_manager->save();

        $fund = new Fund();
        $fund->name = fake()->name();
        $fund->start_year = fake()->year();
        $fund->fund_manager_id = $fund_manager->id;
        $fund->save();
        
        return $fund;
    }
    
    public function test_listReturnFund() {
        $fund = $this->createFund();

        $response = $this->get("/api/funds?name={$fund->name}&year={$fund->start_year}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'funds'  => [
                    [
                        'id' => $fund->id,
                        'name' => $fund->name,
                        'start_year' => $fund->start_year,
                    ]
                ],
            ]);
    }

    public function test_listNotReturnFund() {
        $this->createFund();
        $name = fake()->name();
        $year = fake()->year();

        $response = $this->get("/api/funds?name={$name}&year={$year}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'funds'  => [],
            ]);
    }

    public function test_listInvalidParams() {
        $this->createFund();
        $year = 202020;
        $current_year = date('Y');

        $response = $this->get("/api/funds?year={$year}");

        $response
            ->assertStatus(400)
            ->assertJson([
                "status" => "error",
                "message" => [
                    "year" => [
                        "The year field must not be greater than {$current_year}."
                    ]
                ]
            ]);
    }

    public function test_updateFund() {
        $fund = $this->createFund();
        $params = ['name' => fake()->name()];

        $response = $this->put("/api/funds/{$fund->id}", $params);
        $fund_updated = Fund::find($fund->id);

        $response->assertStatus(200);
        $this->assertEquals($params['name'], $fund_updated->name);
    }

    public function test_updateFundInvalidParams() {
        $fund = $this->createFund();
        $params = ['name' => 'namenamenamenamenamenamenamenamenamenamenamenamenamenamename'];

        $response = $this->put("/api/funds/{$fund->id}", $params);
        $fund_updated = Fund::find($fund->id);

        $response->assertStatus(400)
            ->assertJson([
                "status" => "error",
                "message" => [
                    "name" => [
                        "The name field must not be greater than 50 characters."
                    ]
                ]
            ]);
    }
}
