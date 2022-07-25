<?php

namespace App\Http\Controllers\Api;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class   AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api', ['except' => ['register', 'login', 'logout', 'refresh']]);
    }
    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Зарегестироваться",
     * description="Нужно передать все поля",
     * tags={"Авторизация"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"email","name", "password"},
     *       @OA\Property(property="email", type="string", format="email",  example="test@test.com"),
     *       @OA\Property(property="name", type="string", example="Oxana"),
     *       @OA\Property(property="password", type="string", format="password", example="123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Вернет ошибку валидации, если поля не валидны или какие-то не отправлены",
     * )
     * )
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => 'test',
            'first_name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        TrainerAccount::create([
            'user_id' => $user->id,
            'max_pupils' => TrainerAccount::DEFAULT_MAX_PUPILS,
            'pupils' => 0
        ]);
        $token = auth('api')->attempt($validator->validated());
        return $this->sendResponse(200, $this->respondWithToken($token));
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Войти",
     * description="Нужно передать все поля",
     * tags={"Авторизация"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"email", "password"},
     *       @OA\Property(property="email", type="string", format="email",  example="test@test.com"),
     *       @OA\Property(property="password", type="string", format="password", example="123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Вернет ошибку валидации, если поля не валидны или какие-то не отправлены",
     * )
     * )
     */
    public function login(): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $token = auth('api')->attempt($credentials);
        return $this->sendResponse(200, $this->respondWithToken($token));
    }
    /**
     * @OA\Get(
     *      path="/api/auth/logout",
     *      tags={"Авторизация"},
     *      security={ {"bearer": {} }},
     *      summary="Разлогинить",
     *      description="Удалит токен",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Успешно разлогирован"),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return $this->sendResponse(200, ['message' => 'Успешно разлогирован']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *      path="/api/auth/refresh",
     *      tags={"Авторизация"},
     *      security={ {"bearer": {} }},
     *      summary="Обновить",
     *      description="Обновить токен и время жизни",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL3JlZnJlc2giLCJpYXQiOjE2NTY1OTE1MDAsImV4cCI6MjI2NjUyNjg2NjgzMywibmJmIjoxNjU2NTkzNjEzLCJqdGkiOiJiVHltT2xIZVhoVHRqaTVnIiwic3ViIjoiMTEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.soph4dzb8saATs0G4Gh6uBt-uXAeTeewaOMUDBI20ro"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="string", example=600),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function refresh()
    {
        return $this->sendResponse(200, (array)$this->respondWithToken(auth('api')->refresh()));
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *      path="/api/auth/me",
     *      tags={"Авторизация"},
     *      security={ {"bearer": {} }},
     *      summary="Получить авторизовааного пользоавателя ",
     *      description="Получить авторизовааного пользоавателя ",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example=11),
     *              @OA\Property(property="name", type="string", example="Oksana"),
     *              @OA\Property(property="email", type="string", example="test@test.ru"),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function me()
    {
        return $this->sendResponse(200, ['user' => auth('api')->user()]);
    }
    /**
     * Вернет ошибку авторизации.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginFail()
    {
        return $this->sendError(401, 'Unauthorized', 'Пользователь не авторизован');
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
