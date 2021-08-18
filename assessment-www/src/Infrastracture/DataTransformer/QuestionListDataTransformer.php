<?php

declare(strict_types=1);

namespace App\Infrastracture\DataTransformer;

use App\Domain\Question;
use App\Infrastracture\DataTransformer\Api\TransformerInterface;
use App\Infrastracture\Translation\Api\Translatable;
use App\Infrastracture\Translation\TranslateTrait;

class QuestionListDataTransformer implements TransformerInterface, Translatable
{
    use TranslateTrait;

    /**
     * @var TransformerInterface
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
        if ($this->questionTransformer instanceof Translatable && $this->getTranslator() !== null) {
            $this->questionTransformer->setTranslator($this->getTranslator());
        }

        return [
            'data' => array_map(
                fn(Question $question) => $this->questionTransformer->transformToArray($question),
                $questionList
            )
        ];
    }
}
