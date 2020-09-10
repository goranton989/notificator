<?php

namespace App\Services\Error;


use Exception;

class ErrorService {
    protected ErrorInterface $error;
    protected array $validations = [];

    public function setError(ErrorInterface $error) {
        $this->error = $error;
        return $this;
    }

    /**
     * Transform error to exception instance
     * @return Exception
     */
    public function asException() {
        $error = $this->error;
        return new Exception($error->getMessage(), $error->getErrorResponseCode(), null);
    }

    /**
     * Transform error to json response
     * @return \Illuminate\Http\JsonResponse
     */
    public function asJsonResponse() {
        $error = $this->error;

        return response()->json(
            $this->asArray(),
            $error->getErrorResponseCode(),
            $error->getHeader()
        );
    }

    /**
     * Transform error to array
     * @return array
     */
    public function asArray() {
        $error = $this->error;

        return [
            'code' => $error->getErrorResponseCode(),
            'message' => $error->getMessage(),
        ];
    }
}
