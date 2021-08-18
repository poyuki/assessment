<?php

declare(strict_types=1);

namespace App\Infrastracture\DataTransformer;

use App\Domain\Question;
use App\Infrastracture\DataTransformer\Api\TransformerInterface;

class QuestionListDataTransformer implements TransformerInterface
{
    /**
     * @var \App\Infrastracture\DataTransformer\Api\TransformerInterface
     */
    private TransformerInterface $questionTransformer;

    public function __construct()
    {
        $this->questionTransformer = new QuestionTransformer();
    }

    /**
     * @param array<\App\Domain\Question> $questionList
     * @return array
     */
    public function transformToArray($questionList): array
    {
        return array_map(
            fn(Question $question)=>$this->questionTransformer->transformToArray($question),
            $questionList
        );
    }
}
