<?php

namespace Tests\Unit;

use App\Models\Accounting\TrainerAccount;
use App\Models\Geo\City;
use App\Models\Geo\District;
use App\Models\Geo\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $user = null;
    protected ?District $district = null;
    protected ?Region $region = null;
    protected ?City $city = null;

    protected function createUser(): void
    {
        $this->user = User::create([
            'name' => 'AreaFormTest',
            'email' => 'AreaFormTest@test.ru',
            'password' => bcrypt('password')
        ]);

        TrainerAccount::create(['user_id' => $this->user->id]);
    }

    protected function createDistrict(): void
    {
        $this->district = District::create(['name' => 'name']);
    }

    protected function createRegion(): void
    {
        if (!$this->district) {
            $this->createDistrict();
        }
        $this->region = Region::create([
            'name' => 'name',
            'district_id' => $this->district->id
        ]);
    }

    protected function createCity(): void
    {
        if (!$this->region) {
            $this->createRegion();
        }
        $this->city = City::create([
            'name' => 'name',
            'region_id' => $this->region->id
        ]);
    }

}
