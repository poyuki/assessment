<?php

declare(strict_types=1);

namespace App\Application\Query\Questions\Api;

interface QuestionsServiceInterface
{
    public function execute(string $lang): array;
}