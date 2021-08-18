<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Exception;

class ValidationException extends \Exception implements \JsonSerializable
{
    /**
     * @param array<ValidationError> $errors
     */
    public function __construct(private array $errors = [])
    {
        parent::__construct();
    }

    /**
     * @return array
     */

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function jsonSerialize(): array
    {
        return $this->getErrors();
    }
}