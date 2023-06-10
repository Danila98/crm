<?php

namespace App\Services\Support\Map\Processor;

use App\Models\Area\Area;
use App\Repository\Area\AreaRepository;
use App\Services\Support\Map\GeoApi;

class GeoProcessor
{
    private AreaRepository $areaRepository;

    public function __construct(
        AreaRepository $areaRepository
    )
    {
        $this->areaRepository = $areaRepository;
    }

    public function setCoordinates(Area $area, GeoApi $geoApi)
    {
        $geoCoordinates = $geoApi->getCoordinates($area);
        $area->lat = $geoCoordinates->getLat();
        $area->lon = $geoCoordinates->getLon();
        $this->areaRepository->save($area);
    }
}
