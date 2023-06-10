<?php

namespace App\Http\Controllers\Api\Area;

use App\DataAdapter\Area\AreaDataAdapter;
use App\Exceptions\YandexMapException;
use App\Form\Area\AreaForm;
use App\Http\Controllers\Api\ApiController;
use App\Repository\Accounting\AccountRepository;
use App\Repository\Area\AreaRepository;
use App\Repository\Geo\CityRepository;
use App\Services\Manage\Area\AreaManageService;
use App\Services\Support\Map\YandexMapService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\FlareClient\Http\Exceptions\NotFound;


class AreaController extends ApiController
{
    protected YandexMapService $yandexMapService;
    protected AreaDataAdapter $areaAdapter;
    protected AreaRepository $areaRepository;
    protected CityRepository $cityRepository;
    protected AccountRepository $accountRepository;
    protected AreaManageService $areaManageService;


    public function __construct(
        YandexMapService  $yandexMapService,
        AreaDataAdapter   $areaDataAdapter,
        AreaRepository    $areaRepository,
        CityRepository    $cityRepository,
        AccountRepository $accountRepository,
        AreaManageService $areaManageService,
    )
    {
        $this->yandexMapService = $yandexMapService;
        $this->areaAdapter = $areaDataAdapter;
        $this->areaRepository = $areaRepository;
        $this->cityRepository = $cityRepository;
        $this->accountRepository = $accountRepository;
        $this->areaManageService = $areaManageService;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/area",
     *      tags={"Площадки"},
     *      security={ {"bearer": {} }},
     *      summary="Получить список Площадок",
     *      description="Вернет список Площадок",
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
     *                  "description": "Fanger",
     *                  "work_time": "Fanger",
     *                  "address": "Москва, Ленина 1",
     *                }, {
     *                  "id": 2,
     *                  "name": "Fanger",
     *                  "description": "Fanger",
     *                  "work_time": "Fanger",
     *                  "address": "Москва, Ленина 1",
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
     *                      ),
     *                      @OA\Property(
     *                         property="address",
     *                         type="string",
     *                         example=""
     *                      )
     *                ),
     *             ),
     *     ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function list(Request $request,)
    {
        $areas = $this->areaRepository->findByUser(auth('api')->user());

        return $this->sendResponse(200, ['areas' => $this->areaAdapter->getArrayModelData($areas)]);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/area/{area_id}",
     *      tags={"Площадки"},
     *      security={ {"bearer": {} }},
     *      summary="Получить Площадку по id",
     *      description="Вернет Площадку по id",
     *      @OA\Parameter(
     *      description="ID Площадки",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example="1",
     *      @OA\Schema(
     *          type="integer",
     *           format="int64"
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *       @OA\Property(property="name", type="string",  example="test"),
     *       @OA\Property(property="description", type="string", example="test"),
     *       @OA\Property(property="work_time", type="string", example="test"),
     *       @OA\Property(property="city", type="string", example="Москва"),
     *       @OA\Property(property="street", type="string", example="Ленина"),
     *       @OA\Property(property="house", type="integer", example=1),
     *       @OA\Property(property="building", type="integer", example=1),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     *     )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $area = $this->areaRepository->find($id);
        } catch (NotFound $e) {
            $this->sendError(404, 'Not Found', $e->getMessage());
        } catch (Exception $e) {
            $this->sendError(400, 'error', $e->getMessage());
        }

        return $this->sendResponse(200, ['area' => $this->areaAdapter->getModelData($area)]);
    }

    /**
     * Создает площидку
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     * path="/api/v1/area/add",
     * summary="Добавить площадку",
     * description="Нужно передать поля name,city, street, house",
     * tags={"Площадки"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"name","city", "street", "house"},
     *       @OA\Property(property="name", type="string",  example="test"),
     *       @OA\Property(property="description", type="string", example="test"),
     *       @OA\Property(property="city_id", type="integer", example=1),
     *       @OA\Property(property="street", type="string", example="Ленина"),
     *       @OA\Property(property="house", type="integer", example=1),
     *       @OA\Property(property="building", type="integer", example=1),
     *    ),
     * ),
     * @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Вернет ошибку валидации, если поля не валидны или какие-то не отправлены",
     * )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $request = $request->all();
        $form = new AreaForm();
        if ($form->load($request) && $form->validate()) {
            $area = $this->areaManageService->create($form);

            return $this->sendResponse(201, ['area' => $this->areaAdapter->getModelData($area)]);
        }

        if (!$form->validate()) {
            return $this->sendError(417, 'ValidationError', Response::json($form->getError()));
        }

        return $this->sendError();
    }

    /**
     * Обновит площидку
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     * path="/api/v1/area/update/{area_id}",
     * summary="Обновить площадку",
     * description="Нужно передать поля name,city, street, house",
     * tags={"Площадки"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string",  example="test"),
     *       @OA\Property(property="description", type="string", example="test"),
     *       @OA\Property(property="work_time", type="string", example="test"),
     *       @OA\Property(property="city", type="string", example="Москва"),
     *       @OA\Property(property="street", type="string", example="Ленина"),
     *       @OA\Property(property="house", type="integer", example=1),
     *       @OA\Property(property="building", type="integer", example=1),
     *    ),
     * ),
     * @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Вернет ошибку валидации, если поля не валидны или какие-то не отправлены",
     * )
     * )
     * @throws YandexMapException
     */
    public function update(Request $request, int $id)
    {
        $area = $this->areaRepository->find($id);

        $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'work_time' => 'string',
            'city' => 'string',
            'street' => 'string',
            'house' => 'numeric',
            'building' => 'numeric',
        ]);
        $request = $request->all();
        if (isset($request['city'])) {
            $building = isset($request['building']) ? '/' . $request['building'] : '';
            $address = $request['city'] . ', ' . $request['street'] . ', д.' . $request['house'] . $building;

            $coordinates = $this->yandexMapService->getCoordinatesByAddress($address);
            $area->name = $request['name'];
            $area->description = $request['description'] ?? '';
            $area->address = $address;
            $area->lat = $coordinates['lat'] ?? null;
            $area->lon = $coordinates['lon'] ?? null;
            $area->work_time = $request['work_time'] ?? '';

        } else {
            $area->name = $request['name'];
            $area->description = $request['description'] ?? '';
            $area->work_time = $request['work_time'] ?? '';
        }
        $area->save();

        return $this->sendResponse(201, []);
    }

    /**
     * Удаляет площадку
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Delete(
     *      path="/api/v1/area/delete/{area_id}",
     *      tags={"Площадки"},
     *      security={ {"bearer": {} }},
     *      summary="Удалить площадку по id",
     *      description="Вернет JsonResponse",
     *      @OA\Parameter(
     *      description="ID площадки",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example="1",
     *      @OA\Schema(
     *          type="integer",
     *           format="int64"
     *        )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="bool", example=true),
     *          ),
     *       ),
     * @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     * ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     *     )
     */
    public function destroy(int $id)
    {
        try {
            $area = $this->areaRepository->find($id);
            $area->delete();
        } catch (NotFoundException $e) {
            $this->sendError(404, 'Not Found', $e->getMessage());
        } catch (\Exception $e) {
            $this->sendError(400, 'error', $e->getMessage());
        }
        return $this->sendResponse();
    }
}
