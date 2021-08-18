<?php

declare(strict_types=1);

namespace App\Application\Command\CreateQuestion;

use App\Application\Command\CreateQuestion\Dto\CreateQuestionDto;
use App\Domain\Api\QuestionFactoryInterface;
use App\Domain\Exception\PersistenceException;
use App\Domain\Spi\QuestionRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateQuestionService implements Api\CreateQuestionServiceInterface
{
    public function __construct(
        private QuestionFactoryInterface    $questionFactory,
        private QuestionRepositoryInterface $questionRepository,
        private LoggerInterface             $logger
    ) {
    }

    public function execute(CreateQuestionDto $createQuestionDto): void
    {
        $question = $this->questionFactory->create($createQuestionDto);

        try {
            $this->questionRepository->save($question);
        } catch (PersistenceException $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
//            new BadRequestHttpException();
        }
    }
}
