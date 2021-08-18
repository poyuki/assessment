<?php

declare(strict_types=1);

namespace App\Application\Questions;

use App\Application\Questions\Api\QuestionsServiceInterface;
use App\Domain\Spi\QuestionRepositoryInterface;
use App\Infrastructure\DataTransformer\QuestionListDataTransformer;
use App\Infrastructure\Translation\Api\TranslatorInterface;

class QuestionsService implements QuestionsServiceInterface
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private QuestionListDataTransformer $questionListDataTransformer,
        private TranslatorInterface         $translator
    ) {
    }

    public function execute(string $lang): array
    {
        $questions = $this->questionRepository->getList();

        $this->translator->setTargetLang($lang);
        $this->questionListDataTransformer->setTranslator($this->translator);

        return $this->questionListDataTransformer->transformToArray($questions);
    }
}
