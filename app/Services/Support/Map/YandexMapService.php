<?php

namespace App\Services\Support\Map;


use App\Exceptions\YandexMapException;
use Exception;

class YandexMapService
{
    /**
     * @throws YandexMapException
     */
    public function getCoordinatesByAddress(string $address): array
    {
        try {
            $ch = curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=' . env('YANDEX_GEO') . '&format=json&geocode=' . urlencode($address));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            $res = json_decode($res, true);
            $coordinates = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
            $coordinates = explode(' ', $coordinates);
        }catch (Exception $e)
        {
            throw new YandexMapException('Ошибка при попытке получить координаты с яндекс карт');
        }

        return ['lon' => $coordinates[0], 'lat' => $coordinates[1]];
    }
}
