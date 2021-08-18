<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\DBAL\JsonDBAL;

use App\Infrastructure\Database\DBAL\Api\DataProviderInterface;
use App\Infrastructure\Database\DBAL\Exception\DatabaseAccessException;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JsonDataProvider implements DataProviderInterface
{
    private string $dbFile;

    public function __construct(
        private FilesystemOperator $databaseStorage,
        ParameterBagInterface $parameterBag
    ) {
        $this->dbFile = $parameterBag->get('json_database_file');
    }

    /**
     * @return array
     * @throws DatabaseAccessException
     */
    public function getList(): array
    {
        try {
            $content = $this->readAllDatabase();
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException | FilesystemException $e) {
            throw new DatabaseAccessException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $contextToCommit
     * @throws \App\Infrastructure\Database\DBAL\Exception\DatabaseAccessException
     */
    public function commit(array $contextToCommit): void
    {
        try {
            $rawDbData = $this->readAllDatabase();
            $dbData = json_decode($rawDbData, true, 512, JSON_THROW_ON_ERROR);
            array_push($dbData, ...$contextToCommit);
            $this->databaseStorage->write($this->dbFile, json_encode($dbData, JSON_THROW_ON_ERROR));
        } catch (\JsonException | FilesystemException $e) {
            throw new DatabaseAccessException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return string
     * @throws \League\Flysystem\FilesystemException
     */
    private function readAllDatabase(): string
    {
        return $this->databaseStorage->read($this->dbFile);
    }
}