<?php

namespace App\Http\Controllers\Api\Area;

use App\DataAdapter\Area\GroupAdapter;
use App\Http\Controllers\Api\ApiController;
use App\Models\Area\Group;
use App\Repository\Accounting\AccountRepository;
use App\Repository\Area\GroupRepository;
use Illuminate\Http\Request;
use Intervention\Image\Exception\NotFoundException;

class GroupController extends ApiController
{

    protected AccountRepository $accountRepository;
    protected GroupAdapter $groupAdapter;
    protected GroupRepository $groupRepository;

    public function __construct(AccountRepository $accountRepository, GroupAdapter $groupAdapter, GroupRepository $groupRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->groupAdapter = $groupAdapter;
        $this->groupRepository = $groupRepository;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/group/{group_id}",
     *      tags={"Группы"},
     *      security={ {"bearer": {} }},
     *      summary="Получить группу по id",
     *      description="Вернет группу по id",
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
     *       @OA\Property(property="area", type="object", example={}),

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
        try {
            $group = $this->groupRepository->find($id);
        }catch (NotFoundException $e)
        {

            return $this->sendError(404, 'Not Found', $e->getMessage());
        }catch (\Exception $e)
        {

            return $this->sendError(400, 'unknown error ', $e->getMessage());
        }

        return $this->sendResponse(200, ['group' => $this->groupAdapter->getModelData($group)]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/group",
     *      tags={"Группы"},
     *      security={ {"bearer": {} }},
     *      summary="Получить список групп",
     *      description="Вернет список всех групп текущего пользователя",
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
     *                  "area": {},
     *                }, {
     *                  "id": 2,
     *                  "name": "Fanger",
     *                  "description": "Fanger",
     *                  "area": {},
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
     *                         property="area",
     *                         type="object",
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
        $account = $this->accountRepository->findByUser(auth('api')->user());
        $groups = $this->groupRepository->findByAccount($account);

        return $this->sendResponse(200, $this->groupAdapter->getArrayModelData($groups));
    }
    /**
     * Создает группу
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     * path="/api/v1/group/add",
     * summary="Добавить группу",
     * description="Нужно передать поля name,area_id",
     * tags={"Группы"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"name","area_id"},
     *       @OA\Property(property="name", type="string",  example="test"),
     *       @OA\Property(property="description", type="string", example="test"),
     *       @OA\Property(property="area_id", type="integer", example=1),
     *       @OA\Property(property="category_id", type="integer", example=1),
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
            'description' => 'nullable',
            'area_id' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);
        $request = $request->all();
        $account = $this->accountRepository->findByUser(auth('api')->user());

        $group = Group::create([
            'name'          => $request['name'],
            'description'   => $request['description'] ?? '',
            'area_id'       => $request['area_id'],
            'category_id'   => $request['category_id'],
            'status'        => Group::STATUS_NEW,
            'account_id'    => $account->id,
        ]);

        return $this->sendResponse(201, ['area' => $this->groupAdapter->getModelData($group)]);
    }
    /**
     * Обновит группу
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     * path="/api/v1/group/update/{group_id}",
     * summary="обновить группу",
     * description="Нужно передать поля name,city, street, house",
     * tags={"Группы"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string",  example="test"),
     *       @OA\Property(property="description", type="string", example="test"),
     *       @OA\Property(property="area_id", type="integer", example=1),
     *       @OA\Property(property="status", type="integer", example=1),
     *       @OA\Property(property="category_id", type="integer", example=1),

     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Unauthenticated",
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Вернет ошибку валидации, если поля не валидны или какие-то не отправлены",
     * )
     * )
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'nullable',
            'area_id'       => 'required|numeric',
            'status'        => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);
        $group = $this->groupRepository->find($id);
        $request = $request->all();

        $group->name = $request['name'];
        $group->description = $request['description'];
        $group->area_id = $request['area_id'];
        $group->category_id  = $request['category_id'];
        $group->status = $request['status'];

        $group->save();

        return $this->sendResponse();
    }
    /**
     * Удаляет группу
     *
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Delete(
     *      path="/api/v1/group/delete/{area_id}",
     *      tags={"Группы"},
     *      security={ {"bearer": {} }},
     *      summary="Удалить группу по id",
     *      description="Вернет JsonResponse",
     *      @OA\Parameter(
     *      description="ID группы",
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
        $group = $this->groupRepository->find($id);
        $group->status = Group::STATUS_LEAVE;
        $group->save();

        return $this->sendResponse();
    }
}
