<?php

declare(strict_types=1);

namespace App\Infrastructure\Translation;

use App\Infrastructure\Translation\Api\TranslatorInterface;
use Psr\Log\LoggerInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Translator implements TranslatorInterface
{
    /**
     * @var \Stichoza\GoogleTranslate\GoogleTranslate
     */
    private GoogleTranslate $googleTranslate;

    public function __construct(private LoggerInterface $logger)
    {
        $this->googleTranslate = (new GoogleTranslate())->setSource();
    }

    /**
     * @param string $text
     * @return string|null
     */
    public function translate(string $text): ?string
    {
        try {
            return $this->googleTranslate->translate($text);
        } catch (\ErrorException $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }

        return null;
    }

    public function setTargetLang(string $lang): void
    {
        $this->googleTranslate->setTarget($lang);
    }
}
