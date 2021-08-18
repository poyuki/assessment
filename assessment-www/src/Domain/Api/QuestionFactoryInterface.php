<?php

declare(strict_types=1);

namespace App\Domain\Api;

use App\Application\CreateQuestion\Dto\CreateQuestionDto;
use App\Domain\Question;

interface QuestionFactoryInterface
{
    /**
     * @param \App\Application\CreateQuestion\Dto\CreateQuestionDto $createQuestionDto
     * @return Question
     */
    public function create(CreateQuestionDto $createQuestionDto): Question;
}
