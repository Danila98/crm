<?php

namespace App\Providers\Area;

use App\Jobs\Area\AreaPodcast;
use App\Services\Support\Map\Processor\GeoProcessor;
use App\Services\Support\Map\YandexMapService;
use Illuminate\Support\ServiceProvider;

class GeoProcessorProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bindMethod([AreaPodcast::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(GeoProcessor::class), $app->make(YandexMapService::class));
        });
    }
}
