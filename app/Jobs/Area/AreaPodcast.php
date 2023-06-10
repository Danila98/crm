<?php

namespace App\Jobs\Area;

use App\Models\Area\Area;
use App\Services\Support\Map\GeoApi;
use App\Services\Support\Map\Processor\GeoProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AreaPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function handle(GeoProcessor $processor, GeoApi $geoApi)
    {
        $processor->setCoordinates($this->area, $geoApi);
    }
}
