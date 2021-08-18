<?php

declare(strict_types=1);

namespace App\Application\Query\Questions;

use App\Application\Query\Questions\Api\QuestionsServiceInterface;
use App\Domain\Spi\QuestionRepositoryInterface;
use App\Infrastracture\DataTransformer\QuestionListDataTransformer;
use Psr\Log\LoggerInterface;

class QuestionsService implements QuestionsServiceInterface
{

    public function __construct(
        private LoggerInterface $logger,
        private QuestionRepositoryInterface $questionRepository,
        private QuestionListDataTransformer $questionListDataTransformer
    ) {
    }

    public function execute(string $lang): array
    {
        $questions = $this->questionRepository->getList();

        return $this->questionListDataTransformer->transformToArray($questions);
    }
}
