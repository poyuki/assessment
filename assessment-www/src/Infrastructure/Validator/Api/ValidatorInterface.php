<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Api;

use App\Infrastructure\Validator\Exception\ValidationException;

interface ValidatorInterface
{
    /**
     * @param array $dataForValidation
     * @return array
     * @throws ValidationException
     */
    public function validate(array $dataForValidation): array;
}