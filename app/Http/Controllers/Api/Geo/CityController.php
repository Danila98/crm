<?php

namespace App\Http\Controllers\Api\Geo;

use App\DataAdapter\Geo\CityAdapter;
use App\Filter\Geo\CityFilter;
use App\Http\Controllers\Api\ApiController;
use App\Repository\Geo\CityRepository;
use Illuminate\Http\Request;

class CityController extends ApiController
{
    protected CityRepository $cityRepository;
    protected CityAdapter $cityAdapter;

    public function __construct(CityRepository $cityRepository,
                                CityAdapter $cityAdapter
                               )
    {
        $this->cityRepository = $cityRepository;
        $this->cityAdapter = $cityAdapter;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/cities",
     *      tags={"Геолокоция"},
     *      security={ {"bearer": {} }},
     *      summary="Получить список городов",
     *      description="Вернет список городов, соответствующих get-параметру name",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="categories",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "name": "Fanger",
     *                }, {
     *                  "id": "",
     *                  "name": "",
     *                }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="int",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example=""
     *                      )
     *                ),
     *             ),
     *     ),
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function list(CityFilter $filter)
    {
        $cities =  $this->cityRepository->search($filter);

        return $this->sendResponse(200, ['cities' => $this->cityAdapter->getArrayModelData($cities)]);
    }
}
