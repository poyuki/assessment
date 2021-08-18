<?php

declare(strict_types=1);

namespace App\Infrastructure\DtoFactory;

use App\Application\CreateQuestion\Dto\CreateQuestionDto;

class CreateQuestionDtoFactory
{
    public function create(array $validatedData): CreateQuestionDto
    {
        return new CreateQuestionDto($validatedData);
    }
}
