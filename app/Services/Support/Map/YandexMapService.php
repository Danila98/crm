<?php

namespace App\Services\Support\Map;


use App\Exceptions\YandexMapException;
use App\Models\Area\Area;
use App\Services\Support\Map\Dto\GeoCoordinates;
use Exception;

class YandexMapService implements GeoApi
{

    /**
     * @throws YandexMapException
     */
    public function getCoordinates(Area $area): GeoCoordinates
    {
        try {
            $ch = curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=' .
                env('YANDEX_GEO') .
                '&format=json&geocode=' .
                urlencode($this->prepareAddress($area)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            $res = json_decode($res, true);
            $coordinates = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
            $coordinates = explode(' ', $coordinates);
        } catch (Exception $e) {
            throw new YandexMapException('Ошибка при попытке получить координаты с яндекс карт');
        }

        return new GeoCoordinates($coordinates[1], $coordinates[0]);
    }

    protected function prepareAddress(Area $area): string
    {
        $building = isset($area->building) ? is_int($area->building) ? '/' . $area->building : $area->building : '';
        return $area->city->name . ', ' . $area->street . ', д.' . $area->house . $building;
    }
}
