<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Choice
{
    public function __construct(private string $text)
    {
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
