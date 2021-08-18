<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\DBAL;

use App\Infrastructure\Database\DBAL\Api\DataMapperInterface;
use App\Infrastructure\Database\DBAL\Api\DataProviderInterface;

class EntityManager implements Api\EntityManagerInterface
{

    private array $persistContext = [];

    public function __construct(
        private DataProviderInterface $dataProvider,
        private DataMapperInterface   $dataMapper
    ) {
    }

    public function persist($object): void
    {
        $this->persistContext[] = $this->dataMapper->fromObject($object);
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
