<?php

namespace App\Repository\Geo;

use App\Filter\Geo\CityFilter;
use App\Models\Geo\City;

class CityRepository
{

    public function search(CityFilter $filter)
    {
        return City::filter($filter)->limit(5)->get();
    }

    public function find(int $id)
    {
        return City::find($id);
    }

}
