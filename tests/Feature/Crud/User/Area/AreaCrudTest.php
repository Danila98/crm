<?php

namespace Tests\Feature\Crud\User\Area;

use Tests\Unit\BaseTest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AreaCrudTest extends BaseTest
{
    public function test_create()
    {
        $testData = [
            "name" => "treter",
            "description" => "treter",
            "city_id" => $this->city->id,
            "street" => "treter",
            "house" => 1,
            "building" => "treter"
        ];
        $token = JWTAuth::fromUser($this->trainer);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->post('/api/v1/area/add', $testData);
        $response->assertStatus(201);
        $response = json_decode($response->content(), true);
        $area = $response['area'];
        $this->assertEquals($area['name'], $testData['name']);
        $this->assertEquals($area['description'], $testData['description']);
        $this->assertEquals($area['city']['name'], $this->city->name);
        $this->assertEquals($area['city']['id'], $this->city->id);
        $this->assertEquals($area['street'], $testData['street']);
        $this->assertEquals($area['house'], $testData['house']);
        $this->assertEquals($area['building'], $testData['building']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->createCity();
    }
}
