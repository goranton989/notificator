<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Services\Error\ErrorInterface;
use App\Services\Error\ErrorService;


/**
 * @OA\Swagger(
 *     schemes={"http"},
 *     basePath="/api",
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Notificator API",
 *         @OA\Contact(
 *             email="goranton98@gmail.com"
 *         ),
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header",
 *         scheme="bearer"
 *     ),
 * )
 */
class Controller extends BaseController
{
    private ErrorService $errorService;

    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }

    public function success_response($data, $status = 200, $headers = [])
    {
        return response()->json(compact('data'), $status, $headers);
    }

    public function error_response(ErrorInterface $error)
    {
        return $this->errorService
            ->setError($error)
            ->asJsonResponse();
    }
}
