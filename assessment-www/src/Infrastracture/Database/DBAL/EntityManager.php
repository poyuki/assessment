<?php

namespace App\Infrastracture\Database\DBAL;

use App\Infrastracture\Database\DBAL\Api\DataMapperInterface;
use App\Infrastracture\Database\DBAL\Api\DataProviderInterface;

class EntityManager implements Api\EntityManagerInterface
{

    public function __construct(
        private DataProviderInterface $dataProvider,
        private DataMapperInterface $dataMapper
    )
    {
    }

    public function persist($object): void
    {
        // TODO: Implement persist() method.
    }

    public function flush(): void
    {
        // TODO: Implement flush() method.
    }

    public function findAll(): array
    {
        $rawDataList = $this->dataProvider->getList();
        return $this->dataMapper->toEntityList($rawDataList);
    }
}