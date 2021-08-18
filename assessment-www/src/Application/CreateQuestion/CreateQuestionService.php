<?php

declare(strict_types=1);

namespace App\Application\CreateQuestion;

use App\Application\CreateQuestion\Dto\CreateQuestionDto;
use App\Domain\Api\QuestionFactoryInterface;
use App\Domain\Spi\QuestionRepositoryInterface;
use App\Infrastructure\DataTransformer\QuestionTransformer;

class CreateQuestionService implements Api\CreateQuestionServiceInterface
{
    public function __construct(
        private QuestionFactoryInterface $questionFactory,
        private QuestionRepositoryInterface $questionRepository,
        private QuestionTransformer $questionTransformer
    ) {
    }

    public function execute(CreateQuestionDto $createQuestionDto): array
    {
        $question = $this->questionFactory->create($createQuestionDto);
        $this->questionRepository->save($question);

        return $this->questionTransformer->transformToArray($question);
    }
}
