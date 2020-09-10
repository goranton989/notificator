<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreMessage;
use App\Services\Error\ErrorService;
use App\Services\Error\Forbidden;
use App\Services\Message\MessageService;
use Illuminate\Http\JsonResponse;


class MessageController extends Controller
{
    private MessageService $messageService;

    public function __construct(ErrorService $errorService, MessageService $messageService)
    {
        parent::__construct($errorService);
        $this->messageService = $messageService;
    }

    /**
     * @OA\Post(
     * path="/api/message",
     * summary="Store message",
     * description="Store message to database and etc",
     * operationId="MessageStore",
     * tags={"Message"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass message information",
     *    @OA\JsonContent(
     *       required={"message"},
     *       @OA\Property(property="message", type="string", example="Hello world"),
     *    ),
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Resource is forbidden.",
     *    @OA\JsonContent(
     *       @OA\Property(property="code", type="integer", example=403),
     *       @OA\Property(property="message", type="string", example="Error description.")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Message has been store.",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="boolean", example=true),
     *    ),
     * )
     * )
     * @param StoreMessage $request
     * @return JsonResponse
     */
    public function store(StoreMessage $request)
    {
        $user = $request->user();

        if (!$this->messageService->userCanStore($user)) {
            return $this->error_response(new Forbidden());
        }

        $this->messageService->storeAndNotify($request->get('message'), $user);

        return $this->success_response(true);
    }
}
