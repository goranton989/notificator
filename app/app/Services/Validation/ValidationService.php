<?php

namespace App\Services\Validation;

use App\Services\Error\ErrorService;
use App\Services\Validation\Interfaces\ValidationInterface;
use Exception;

class ValidationService {
    private array $validations = [];
    private ErrorService $errorService;

    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    /**
     * Push new validation rule to stack
     * @param ValidationInterface $validation validation rule
     * @return $this
     */
    public function pushValidation(ValidationInterface $validation) {
        $this->validations[] = $validation;
        return $this;
    }

    /**
     * Run exists validation rules
     * @param $payload
     * @return bool
     * @throws Exception
     */
    public function runValidations($payload) {
        /** @var ValidationInterface $validation */
        foreach ($this->validations as $validation) {
            if (!$validation->validate($payload)) {
                throw $this->errorService
                    ->setError($validation->getErrorInstance())
                    ->asException();
            }
        }

        return true;
    }
}
