<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\DBAL\Api;

use App\Domain\Question;

interface DataMapperInterface
{
    /**
     * @param array $list
     * @return array
     * @throws \App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntityList(array $list): array;

    /**
     * @param array $object
     * @return object
     * @throws \App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntity(array $object): object;

    /**
     * @param Question $object
     * @return array
     * @throws \App\Infrastructure\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function fromObject($object): array;
}