<?php

namespace App\DataAdapter\Area;

use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class AreaDataAdapter  extends DataAdapter
{

    function getModelData(Model $area): array
    {
        return [
            'id' => $area->id,
            'name' => $area->name,
            'description' => $area->description,
            'address' => $area->address,
            'coords' => [$area->lat, $area->lon],
            'work_time' => $area->work_time,
        ];
    }
}
