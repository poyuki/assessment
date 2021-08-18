<?php

declare(strict_types=1);

namespace App\Domain;

use App\Application\Command\CreateQuestion\Dto\CreateQuestionDto;
use App\Domain\Entity\Choice;

class QuestionFactory implements Api\QuestionFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(CreateQuestionDto $createQuestionDto): Question
    {
        $question = new Question(
            $createQuestionDto->getText(),
            new \DateTime($createQuestionDto->getCreatedAt())
        );
        foreach ($createQuestionDto->getChoices() as $choice) {
            $question->attachChoice(new Choice($choice->text));
        }
        return $question;
    }
}
