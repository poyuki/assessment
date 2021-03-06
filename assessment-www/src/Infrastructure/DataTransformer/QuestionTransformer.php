<?php

declare(strict_types=1);

namespace App\Infrastructure\DataTransformer;

use App\Domain\Entity\Choice;
use App\Domain\Question;
use App\Infrastructure\DataTransformer\Api\TransformerInterface;
use App\Infrastructure\Translation\Api\Translatable;
use App\Infrastructure\Translation\TranslateTrait;

class QuestionTransformer implements TransformerInterface, Translatable
{
    use TranslateTrait;

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
        if ($this->choicesTransformer instanceof Translatable && $this->getTranslator() !== null) {
            $this->choicesTransformer->setTranslator($this->getTranslator());
        }

        return [
            'text' => $this->getTranslator()?->translate($object->getText()) ?? $object->getText(),
            'createdAt' => $object->getCreatedAt()->format(DATE_RFC3339),
            'choices' => array_map(
                fn(Choice $choice) => $this->choicesTransformer->transformToArray($choice),
                $object->getChoices()
            )
        ];
    }
}
