<?php

namespace App\Application\Command\CreateQuestion\Api;

use App\Application\Command\CreateQuestion\Dto\CreateQuestionDto;

interface CreateQuestionServiceInterface
{
    public function execute(CreateQuestionDto $createQuestionDto):void;
}