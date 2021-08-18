<?php

declare(strict_types=1);

namespace App\Infrastracture\Translation\Api;

interface TranslatorInterface
{
    public function translate(string $text): string;

    public function setTargetLang(string $lang): void;
}
