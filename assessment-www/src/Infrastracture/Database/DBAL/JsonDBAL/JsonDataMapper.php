<?php

namespace App\Infrastracture\Database\DBAL\JsonDBAL;

use App\Domain\Entity\Choice;
use App\Domain\Question;
use App\Infrastracture\Database\DBAL\Api\DataMapperInterface;
use App\Infrastracture\Database\DBAL\Exception\UnsupportedDataMappingException;
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
     * @throws \App\Infrastracture\Database\DBAL\Exception\UnsupportedDataMappingException
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
     * @throws \App\Infrastracture\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntityList(array $list): array
    {
        return array_map(fn($listElement) => $this->toEntity($listElement), $list);
    }

    public function fromObject($object): array
    {
        return [];
    }
}