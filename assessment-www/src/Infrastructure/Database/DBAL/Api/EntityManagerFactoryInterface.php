<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\DBAL\Api;

interface EntityManagerFactoryInterface
{
    public function create(): EntityManagerInterface;
}
