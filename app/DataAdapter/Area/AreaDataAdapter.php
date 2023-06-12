<?php

namespace App\DataAdapter\Area;

use App\Models\Area\Area;
use App\Models\Geo\City;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class AreaDataAdapter extends DataAdapter
{

    function getModelData(Model $area): array
    {
        return [
            'id' => $area->id,
            'name' => $area->name,
            'description' => $area->description,
            'city_id' => $area->city_id,
            'street' => $area->street,
            'house' => $area->house,
            'building' => $area->building,
            'coords' => [$area->lat, $area->lon],
        ];
    }

    public function getModelAllData(Area $area, City $city): array
    {
        return [
            'id' => $area->id,
            'name' => $area->name,
            'description' => $area->description,
            'street' => $area->street,
            'house' => $area->house,
            'building' => $area->building,
            'coords' => [$area->lat, $area->lon],
            'city' => [
                'id' => $city->id,
                'name' => $city->name,
            ],

        ];
    }
}
