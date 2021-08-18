<?php

namespace App\Infrastracture\Database\DBAL;

use App\Infrastracture\Database\DBAL\Api\DataMapperInterface;
use App\Infrastracture\Database\DBAL\Api\DataProviderInterface;

class EntityManager implements Api\EntityManagerInterface
{
    public function __construct(
        private DataProviderInterface $dataProvider,
        private DataMapperInterface $dataMapper,
        private array $persistContext = []
    ) {
    }

    public function persist($object): void
    {
        $this->persistContext[]=$this->dataMapper->fromObject($object);
    }

    public function flush(): void
    {
        $this->dataProvider->commit($this->persistContext);
    }

    public function findAll(): array
    {
        $rawDataList = $this->dataProvider->getList();
        return $this->dataMapper->toEntityList($rawDataList);
    }
}