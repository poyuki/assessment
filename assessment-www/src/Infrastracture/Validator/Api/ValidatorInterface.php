<?php

namespace App\Infrastracture\Validator\Api;

use App\Infrastracture\Validator\Exception\ValidationException;

interface ValidatorInterface
{
    /**
     * @param array $dataForValidation
     * @return array
     * @throws ValidationException
     */
    public function validate(array $dataForValidation): array;
}