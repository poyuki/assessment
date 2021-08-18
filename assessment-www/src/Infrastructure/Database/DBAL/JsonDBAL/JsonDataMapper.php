<?php

namespace App\Infrastructure\Database\DBAL\JsonDBAL;

use App\Domain\Entity\Choice;
use App\Domain\Question;
use App\Infrastructure\Database\DBAL\Api\DataMapperInterface;
use App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException;
use DateTime;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class JsonDataMapper implements DataMapperInterface
{

    private PropertyAccessorInterface $pa;

    public function __construct()
    {
        $paBuilder = PropertyAccess::createPropertyAccessorBuilder();
        $paBuilder->enableExceptionOnInvalidPropertyPath();
        $this->pa = $paBuilder->getPropertyAccessor();
    }

    /**
     * @param array $object
     * @return object
     * @throws \App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntity(array $object): object
    {
        $choices = $this->pa->getValue($object, '[choices]');
        if (!is_array($choices)) {
            throw new UnsupportedDataMappingException();
        }
        try {
            $resultChoices = array_map(
                fn(array $choice) => new Choice($this->pa->getValue($choice, '[text]')),
                $choices
            );
            return new Question(
                $this->pa->getValue($object, '[text]'),
                new DateTime($this->pa->getValue($object, '[createdAt]')),
                $resultChoices
            );
        } catch (\Throwable $e) {
            throw new UnsupportedDataMappingException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $list
     * @return array
     * @throws \App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntityList(array $list): array
    {
        return array_map(fn($listElement) => $this->toEntity($listElement), $list);
    }

    /**
     * @param Question $object
     * @return array
     */
    public function fromObject($object): array
    {
        $result = [
            'text' => $object->getText(),
            'createdAt' => $object->getCreatedAt()->format(DATE_RFC3339),
            'choices' => [],
        ];

        /** @var Choice $choice */
        foreach ($object->getChoices() as $choice) {
            $result['choices'][] = ['text' => $choice->getText()];
        }

        return $result;
    }
}