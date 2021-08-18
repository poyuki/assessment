<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use App\Domain\Question;
use App\Domain\Spi\QuestionRepositoryInterface;
use App\Infrastructure\Database\DBAL\Api\EntityManagerInterface;

class QuestionsRepository implements QuestionRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function save(Question $question): void
    {
        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getList(): array
    {
        return $this->entityManager->findAll();
    }
}
