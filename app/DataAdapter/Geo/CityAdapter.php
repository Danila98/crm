<?php

namespace App\DataAdapter\Geo;

use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class CityAdapter extends DataAdapter
{

    function getModelData(Model $city): array
    {
        return [
            'name' => $city->name,
            'id' => $city->id
        ];
    }
}
