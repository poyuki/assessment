<?php

namespace App\Infrastructure\Database\DBAL\Api;

interface EntityManagerInterface
{
    public function persist($object): void;

    public function flush(): void;

    public function findAll(): array;
}