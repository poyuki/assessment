<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\DBAL;

use App\Infrastructure\Database\DBAL\Api\EntityManagerFactoryInterface;
use App\Infrastructure\Database\DBAL\Api\EntityManagerInterface;
use App\Infrastructure\Database\DBAL\CsvDBAL\CsvDataMapper;
use App\Infrastructure\Database\DBAL\CsvDBAL\CsvDataProvider;
use App\Infrastructure\Database\DBAL\JsonDBAL\JsonDataMapper;
use App\Infrastructure\Database\DBAL\JsonDBAL\JsonDataProvider;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EntityManagerFactory implements EntityManagerFactoryInterface
{
    public const JSON_DB = 'json';
    public const CSV_DB = 'csv';
    private string $dbType;

    public function __construct(
        private ParameterBagInterface $parameterBag,
        private FilesystemOperator $databaseStorage
    ) {
        $this->dbType = $parameterBag->get('db_type');
    }

    public function create(): EntityManagerInterface
    {
        if ($this->dbType === self::JSON_DB) {
            $dataProvider = new JsonDataProvider($this->databaseStorage, $this->parameterBag);
            $dataMapper = new JsonDataMapper();
        } elseif ($this->dbType === self::CSV_DB) {
            $dataProvider = new CsvDataProvider($this->parameterBag);
            $dataMapper = new CsvDataMapper();
        } else {
            throw new \RuntimeException('unsupported db type');
        }
        return new EntityManager($dataProvider, $dataMapper);
    }
}
