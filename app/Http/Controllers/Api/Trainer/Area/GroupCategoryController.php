<?php

namespace App\Http\Controllers\Api\Trainer\Area;

use App\Http\Controllers\Api\ApiController;
use App\Models\Area\GroupCategory;
use App\Repository\Accounting\AccountRepository;
use App\Repository\Area\GroupCategoryRepository;
use Illuminate\Http\Request;

class GroupCategoryController extends ApiController
{

    protected AccountRepository $accountRepository;
    protected GroupCategoryRepository $categoryRepository;

    public function __construct(AccountRepository $accountRepository,
                                GroupCategoryRepository $categoryRepository,
    )
    {
        $this->accountRepository = $accountRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/group/category",
     *      tags={"Группы"},
     *      security={ {"bearer": {} }},
     *      summary="Получить список категорий групп",
     *      description="Вернет список всех категорий групп текущего пользователя",
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
     *                  "id": 2,
     *                  "name": "Fanger",
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
        $categories = $this->categoryRepository->findByAccount($account);

        return $this->sendResponse(200, ['categories' => $categories]);
    }

    /**
     * Создает категорию для группы
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     * path="/api/v1/group/category/add",
     * summary="Добавить категорию группы",
     * description="Нужно передать поля name",
     * tags={"Группы"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string",  example="test"),
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
            'name'          => 'required|string',
        ]);
        $request = $request->all();
        $account = $this->accountRepository->findByUser(auth('api')->user());
        $category = GroupCategory::create([
           'name' => $request['name'],
            'account_id' => $account->id
        ]);

        return $this->sendResponse(201, ['category' => $category]);
    }

    /**
     * Создает категорию для группы
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     * path="/api/v1/group/category/update/{category_id}",
     * summary="Обновить категорию группы",
     * description="Нужно передать поля name",
     * tags={"Группы"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string",  example="test"),
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
    public function update(int $id, Request $request)
    {
        try {
            $category = $this->categoryRepository->find($id);
        }catch (\Exception $e)
        {
            return $this->sendError(404, 'Not found', $e->getMessage());
        }

        $request->validate([
            'name'          => 'required|string',
        ]);
        $request = $request->all();
        $category->name = $request['name'];
        $category->save();

        return $this->sendResponse();
    }

    public function destroy(int $id)
    {
        $category = $this->categoryRepository->find($id);
        $category->delete();

        return $this->sendResponse();
    }
}
