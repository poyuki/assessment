<?php

namespace App\Infrastracture\Translation;

use App\Infrastracture\Translation\Api\TranslatorInterface;

trait TranslateTrait
{
    private ?TranslatorInterface $translator = null;

    /**
     * @param \App\Infrastracture\Translation\Api\TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * @return \App\Infrastracture\Translation\Api\TranslatorInterface|null
     */
    public function getTranslator(): ?TranslatorInterface
    {
        return $this->translator;
    }
}