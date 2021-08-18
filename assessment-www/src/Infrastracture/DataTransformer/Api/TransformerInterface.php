<?php

declare(strict_types=1);

namespace App\Infrastracture\DataTransformer\Api;

interface TransformerInterface
{
    public function transformToArray($object): array;
}
