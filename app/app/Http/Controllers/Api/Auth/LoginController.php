<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Services\Auth\Errors\InvalidCredentials;
use App\Services\AuthService;
use App\Services\Error\ErrorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    public function __construct(ErrorService $errorService, AuthService $authService)
    {
        parent::__construct($errorService);
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Login user",
     * description="Login user",
     * operationId="AuthLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user information",
     *    @OA\JsonContent(
     *       required={"email", "password"},
     *       @OA\Property(property="email", type="string", format="email", example="tester@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="12345687"),
     *    ),
     * ),
     * @OA\Response(
     *     response="200",
     *     description="ok",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     description="The response data",
     *                     @OA\Items
     *                 ),
     *                 example={
     *                     "data": { "access_token": "" }
     *                 }
     *             )
     *         )
     *     }
     *  ),
     *  @OA\Response(
     *    response=403,
     *    description="Invalid credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="code", type="integer", example=403),
     *       @OA\Property(property="message", type="string", example="Error description"),
     *    ),
     *  ),
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if ($access_token = $this->authService->login($credentials)) {
            return $this->success_response(compact('access_token'));
        }

        return $this->error_response(new InvalidCredentials());
    }
}
