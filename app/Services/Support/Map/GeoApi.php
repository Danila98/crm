<?php

namespace App\Services\Support\Map;

use App\Models\Area\Area;
use App\Services\Support\Map\Dto\GeoCoordinates;

interface GeoApi
{
    public function getCoordinates(Area $area): GeoCoordinates;
}
