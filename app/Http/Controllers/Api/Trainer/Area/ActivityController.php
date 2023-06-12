<?php

namespace App\Http\Controllers\Api\Trainer\Area;

use App\DataAdapter\Area\ActivityAdapter;
use App\Http\Controllers\Api\ApiController;
use App\Repository\Accounting\AccountRepository;
use App\Repository\Area\ActivityRepository;
use Illuminate\Http\Request;

class ActivityController extends ApiController
{
    protected AccountRepository $accountRepository;
    protected ActivityRepository $activityRepository;
    protected ActivityAdapter $activityAdapter;

    public function __construct(AccountRepository $accountRepository, ActivityRepository $activityRepository, ActivityAdapter $activityAdapter)
    {
        $this->accountRepository = $accountRepository;
        $this->activityRepository = $activityRepository;
        $this->activityAdapter = $activityAdapter;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/activity/{activity_id}",
     *      tags={"Занятия"},
     *      security={ {"bearer": {} }},
     *      summary="Получить занятие по id",
     *      description="Вернет занятие по id",
     *      @OA\Parameter(
     *      description="ID занятия",
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
     *       @OA\Property(property="start", type="date",  example="2022-08-07 23:12:30"),
     *       @OA\Property(property="end", type="date",  example="2022-08-07 23:12:30"),
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
    public function show(int $id)
    {
        $activity = $this->activityRepository->find($id);

        return $this->sendResponse(200, ['activity' => $this->activityAdapter->getModelData($activity)]);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/activity/",
     *      tags={"Занятия"},
     *      security={ {"bearer": {} }},
     *      summary="Получить список занятий",
     *      description="Вернет список всех занятий текущего пользователя",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="activities",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "name": "Fanger",
     *                  "start": "2022-08-07 23:12:30",
     *                  "end": "2022-08-07 23:12:30",
     *                }, {
     *                  "id": 2,
     *                  "name": "Fanger",
     *                  "start": "2022-08-07 23:12:30",
     *                  "end": "2022-08-07 23:12:30",
     *                }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="int",
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
    public function list()
    {
        $activities = $this->activityRepository->findByUser(auth('api')->user());

        return $this->sendResponse(200, ['categories' => $this->activityAdapter->getArrayModelData($activities)]);
    }

    /**
     * Создает категорию для занятия
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     * path="/api/v1/activity/add",
     * summary="Добавить занятие",
     * description="Нужно передать поля name, start, end, area_id, category_id",
     * tags={"Занятия"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string",  example="test"),
     *       @OA\Property(property="start", type="date",  example="2022-08-07 23:12:30"),
     *       @OA\Property(property="end", type="date",  example="2022-08-07 23:12:30"),
     *       @OA\Property(property="area_id", type="integer",  example=1),
     *       @OA\Property(property="category_id", type="integer",  example=1),
     *       @OA\Property(property="group_id", type="integer",  example=1),
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'area_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'group_id' => 'nullable|numeric',
        ]);

        $request = $request->all();
        $account = $this->accountRepository->findByUser(auth('api')->user());
        $request['account_id'] = $account->id;
        $activity = $this->activityRepository->create($request);

        return $this->sendResponse(201, ['activity' => $this->activityAdapter->getModelData($activity)]);
    }
}
