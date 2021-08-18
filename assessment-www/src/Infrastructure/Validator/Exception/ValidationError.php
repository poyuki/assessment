<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Exception;

class ValidationError implements \JsonSerializable
{
    public function __construct(private string $field, private string $description)
    {
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function jsonSerialize(): array
    {
        return [
            'field' => $this->getField(),
            'description' => $this->getDescription()
        ];
    }
}
