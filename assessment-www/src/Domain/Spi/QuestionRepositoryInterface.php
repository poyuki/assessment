<?php

namespace App\Domain\Spi;

use App\Domain\Exception\PersistenceException;
use App\Domain\Question;

interface QuestionRepositoryInterface
{
    /**
     * @param Question $question
     * @throws PersistenceException
     */
    public function save(Question $question): void;

    /**
     * @return array<Question>
     */
    public function getList(): array;

}