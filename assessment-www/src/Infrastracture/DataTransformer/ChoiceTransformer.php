<?php

declare(strict_types=1);

namespace App\Infrastracture\DataTransformer;

use App\Domain\Entity\Choice;
use App\Infrastracture\DataTransformer\Api\TransformerInterface;


class ChoiceTransformer implements TransformerInterface
{
    /**
     * @param Choice $object
     * @return array
     */
    public function transformToArray($object): array
    {
        return [
            'text' => $object->getText()
        ];
    }
}
