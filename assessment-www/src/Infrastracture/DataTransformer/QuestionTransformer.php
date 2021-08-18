<?php

declare(strict_types=1);

namespace App\Infrastracture\DataTransformer;

use App\Domain\Entity\Choice;
use App\Domain\Question;
use App\Infrastracture\DataTransformer\Api\TransformerInterface;

class QuestionTransformer implements TransformerInterface
{

    /**
     * @var TransformerInterface
     */
    private TransformerInterface $choicesTransformer;

    public function __construct()
    {
        $this->choicesTransformer = new ChoiceTransformer();
    }

    /**
     * @param Question $object
     * @return array
     */
    public function transformToArray($object): array
    {
        return [
            'text' => $object->getText(),
            'createdAt' => $object->getCreatedAt()->format(DATE_RFC3339),
            'choices' => array_map(
                fn(Choice $choice) => $this->choicesTransformer->transformToArray($choice),
                $object->getChoices()
            )
        ];
    }
}