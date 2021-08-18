<?php

namespace App\Infrastracture\Translation\Api;

interface Translatable
{
    public function setTranslator(TranslatorInterface $translator): void;

    public function getTranslator(): ?TranslatorInterface;
}