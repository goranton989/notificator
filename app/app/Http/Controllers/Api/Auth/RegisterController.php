<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RegisterForm;
use App\Services\AuthService;
use App\Services\Error\ErrorService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private AuthService $authService;

    public function __construct(ErrorService $errorService, AuthService $authService)
    {
        parent::__construct($errorService);
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Register new user",
     * description="Create new user by pass credentials",
     * operationId="AuthRegister",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user information",
     *    @OA\JsonContent(
     *       required={"name", "email", "password", "password_confirmation"},
     *       @OA\Property(property="name", type="string", example="Anton"),
     *       @OA\Property(property="email", type="string", format="email", example="tester@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="12345687"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="12345687"),
     *    ),
     * ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="data", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(
     *           property="error",
     *           type="array",
     *           @OA\Items(type="string"),
     *       ),
     *    ),
     *  ),
     * )
     * @param RegisterForm $request
     * @return JsonResponse
     */
    public function __invoke(RegisterForm $request)
    {
        $user = $this->authService
            ->create(
                $request->only(['name', 'email']),
                $request->get('password')
            );

        return $this->success_response($user);
    }
}
