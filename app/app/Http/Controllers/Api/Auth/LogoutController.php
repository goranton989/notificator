<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Services\AuthService;
use App\Services\Error\ErrorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
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
     * path="/api/auth/logout",
     * summary="Revoke access token",
     * description="Revoke access token and logout current user",
     * operationId="AuthLogout",
     * tags={"Auth"},
     * security={
     *    {
     *        "Bearer": {}
     *    }
     * },
     * @OA\Response(
     *    response=200,
     *    description="Success logout",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="boolean", example=true),
     *    ),
     * )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $this->authService->logout($request->user('api'));
        return $this->success_response(true);
    }
}
