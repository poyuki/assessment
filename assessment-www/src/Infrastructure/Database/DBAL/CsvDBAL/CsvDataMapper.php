<?php

namespace App\Infrastructure\Database\DBAL\CsvDBAL;

use App\Domain\Entity\Choice;
use App\Domain\Question;
use App\Infrastructure\Database\DBAL\Api\DataMapperInterface;
use App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException;
use Symfony\Component\PropertyAccess\PropertyAccess;

class CsvDataMapper implements DataMapperInterface
{
    public function __construct()
    {
        $paBuilder = PropertyAccess::createPropertyAccessorBuilder();
        $paBuilder->enableExceptionOnInvalidPropertyPath();
        $this->pa = $paBuilder->getPropertyAccessor();
    }

    /**
     * @inheritDoc
     */
    public function toEntityList(array $list): array
    {
        return array_map(fn($listElement) => $this->toEntity($listElement), $list);
    }

    /**
     * @inheritDoc
     */
    public function toEntity(array $object): object
    {
        try {
            $choices = [
                new Choice($this->pa->getValue($object, '[Choice 1]')),
                new Choice($this->pa->getValue($object, '[Choice 2]')),
                new Choice($this->pa->getValue($object, '[Choice 3]'))
            ];

            return new Question(
                $this->pa->getValue($object, '[Question text]'),
                new \DateTime($this->pa->getValue($object, '[Created At]')),
                $choices
            );
        } catch (\Throwable $e) {
            throw new UnsupportedDataMappingException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param Question $object
     * @return array
     * @throws \App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function fromObject($object): array
    {
        [$choice1, $choice2, $choice3] = $object->getChoices();
        if (!$choice1 instanceof Choice || !$choice2  instanceof Choice || !$choice3  instanceof Choice) {
            throw new UnsupportedDataMappingException('wrong choice count');
        }

        return [
            'Question text' => $object->getText(),
            'Created At' => $object->getCreatedAt()->format(DATE_RFC3339),
            "Choice 1" => $choice1->getText(),
            "Choice 2" => $choice2->getText(),
            "Choice 3" => $choice3->getText(),
        ];
    }
}