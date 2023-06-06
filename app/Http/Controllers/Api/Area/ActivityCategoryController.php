<?php

namespace App\Http\Controllers\Api\Area;

use App\DataAdapter\Area\ActivityCategoryAdapter;
use App\Http\Controllers\Api\ApiController;
use App\Repository\Accounting\AccountRepository;
use App\Repository\Area\ActivityCategoryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class ActivityCategoryController extends ApiController
{
    protected AccountRepository $accountRepository;
    protected ActivityCategoryAdapter $activityCategoryAdapter;
    protected ActivityCategoryRepository $categoryRepository;

    public function __construct(
        AccountRepository          $accountRepository,
        ActivityCategoryAdapter    $activityCategoryAdapter,
        ActivityCategoryRepository $categoryRepository
    )
    {
        $this->accountRepository = $accountRepository;
        $this->activityCategoryAdapter = $activityCategoryAdapter;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/activity/category/{category_id}",
     *      tags={"Занятия"},
     *      security={ {"bearer": {} }},
     *      summary="Получить категорию по id",
     *      description="Вернет категории по id",
     *      @OA\Parameter(
     *      description="ID категории",
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
            $category = $this->categoryRepository->get($id);
        } catch (NotFound $e) {

            return $this->sendError(404, 'Not Found', $e->getMessage());
        } catch (Exception $e) {

            return $this->sendError(400, 'unknown error ', $e->getMessage());
        }

        return $this->sendResponse(200, ['category' => $this->activityCategoryAdapter->getModelData($category)]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/activity/category",
     *      tags={"Занятия"},
     *      security={ {"bearer": {} }},
     *      summary="Получить список категорию занятий",
     *      description="Вернет список всех категорий занятий текущего пользователя",
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
    public function list(): JsonResponse
    {
        $categories = $this->categoryRepository->findByUser(auth('api')->user());

        return $this->sendResponse(200, ['categories' => $this->activityCategoryAdapter->getArrayModelData($categories)]);
    }

    /**
     * Создает категорию для занятия
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     * path="/api/v1/activity/category/add",
     * summary="Добавить категорию занятия",
     * description="Нужно передать поля name",
     * tags={"Занятия"},
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
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'price_subscription' => 'nullable|numeric',
        ]);
        $account = $this->accountRepository->findByUser(auth('api')->user());
        $request = $request->all();
        $request['account_id'] = $account->id;
        $category = $this->categoryRepository->create($request);

        return $this->sendResponse(201, ['category' => $this->activityCategoryAdapter->getModelData($category)]);
    }

    /**
     * обновляет категорию для заняимй
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Put(
     * path="/api/v1/activity/category/update/{category_id}",
     * summary="Обновить категорию занятия",
     * description="Нужно передать поля name",
     * tags={"Занятия"},
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
    public function update(Request $request, int $category_id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'price_subscription' => 'nullable|numeric',
        ]);
        $category = $this->categoryRepository->update($category_id, $request->all());

        return $this->sendResponse(200, ['category' => $this->activityCategoryAdapter->getModelData($category)]);
    }


    public function destroy(int $id)
    {
        $category = $this->categoryRepository->find($id);
        $category->delete();

        return $this->sendResponse();
    }
}
