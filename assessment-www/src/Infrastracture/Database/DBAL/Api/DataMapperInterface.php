<?php

namespace App\Infrastracture\Database\DBAL\Api;

interface DataMapperInterface
{
    /**
     * @param array $list
     * @return array
     * @throws \App\Infrastracture\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntityList(array $list): array;

    /**
     * @param array $object
     * @return object
     * @throws \App\Infrastracture\Database\DBAL\Exception\UnsupportedDataMappingException
     */
    public function toEntity(array $object): object;

    public function fromObject($object): array;
}