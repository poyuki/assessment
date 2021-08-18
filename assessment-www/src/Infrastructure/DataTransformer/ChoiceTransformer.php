<?php

declare(strict_types=1);

namespace App\Infrastructure\DataTransformer;

use App\Domain\Entity\Choice;
use App\Infrastructure\DataTransformer\Api\TransformerInterface;
use App\Infrastructure\Translation\Api\Translatable;
use App\Infrastructure\Translation\TranslateTrait;

class ChoiceTransformer implements TransformerInterface, Translatable
{
    use TranslateTrait;

    /**
     * @param Choice $object
     * @return array
     */
    public function transformToArray($object): array
    {
        return [
            'text' => $this->getTranslator()?->translate($object->getText()) ?? $object->getText()
        ];
    }
}
