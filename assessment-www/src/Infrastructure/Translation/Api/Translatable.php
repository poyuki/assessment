<?php

namespace App\Infrastructure\Translation\Api;

interface Translatable
{
    public function setTranslator(TranslatorInterface $translator): void;

    public function getTranslator(): ?TranslatorInterface;
}