<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Entity\Choice;
use App\Domain\Spi\TranslatorInterface;
use DateTime;

class Question
{
    public function __construct(
        private string $text,
        private DateTime $createdAt,
        private array $choices = []
    ) {
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    public function attachChoice(Choice $choice): void
    {
        $this->choices[] = $choice;
    }
}
