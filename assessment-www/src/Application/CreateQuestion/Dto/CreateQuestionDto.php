<?php

namespace App\Application\CreateQuestion\Dto;

class CreateQuestionDto
{
    public function __construct(private array $inputData)
    {
    }

    public function getText(): string
    {
        return $this->inputData['text'];
    }

    public function getChoices(): array
    {
        return $this->inputData['choices'];
    }
}