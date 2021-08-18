<?php

namespace App\Infrastructure\Translation;

use App\Infrastructure\Translation\Api\TranslatorInterface;

trait TranslateTrait
{
    private ?TranslatorInterface $translator = null;

    /**
     * @param \App\Infrastructure\Translation\Api\TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * @return \App\Infrastructure\Translation\Api\TranslatorInterface|null
     */
    public function getTranslator(): ?TranslatorInterface
    {
        return $this->translator;
    }
}