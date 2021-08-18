<?php

declare(strict_types=1);

namespace App\Infrastracture\Translation;

use App\Infrastracture\Translation\Api\TranslatorInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Translator implements TranslatorInterface
{
    /**
     * @var \Stichoza\GoogleTranslate\GoogleTranslate
     */
    private GoogleTranslate $googleTranslate;

    public function __construct()
    {
        $this->googleTranslate = (new GoogleTranslate())->setSource();
    }

    /**
     * @param string $text
     * @return string
     * @throws \ErrorException
     */
    public function translate(string $text): string
    {
        return $this->googleTranslate->translate($text);
    }

    public function setTargetLang(string $lang): void
    {
        $this->googleTranslate->setTarget($lang);
    }
}
