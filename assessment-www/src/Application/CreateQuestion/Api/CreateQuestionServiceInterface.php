<?php

declare(strict_types=1);

namespace App\Application\CreateQuestion\Api;

use App\Application\CreateQuestion\Dto\CreateQuestionDto;

interface CreateQuestionServiceInterface
{
    public function execute(CreateQuestionDto $createQuestionDto): array;
}
