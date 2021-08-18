<?php

declare(strict_types=1);

namespace App\Infrastracture\DataTransformer;

use App\Domain\Entity\Choice;
use App\Infrastracture\DataTransformer\Api\TransformerInterface;
use App\Infrastracture\Translation\Api\Translatable;
use App\Infrastracture\Translation\TranslateTrait;


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
