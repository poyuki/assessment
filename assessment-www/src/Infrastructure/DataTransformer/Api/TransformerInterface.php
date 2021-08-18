<?php

declare(strict_types=1);

namespace App\Infrastructure\DataTransformer\Api;

interface TransformerInterface
{
    public function transformToArray($object): array;
}
