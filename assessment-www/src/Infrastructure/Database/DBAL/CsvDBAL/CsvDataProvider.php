<?php

namespace App\Infrastructure\Database\DBAL\CsvDBAL;

use App\Infrastructure\Database\DBAL\Api\DataProviderInterface;
use App\Infrastructure\Database\DBAL\Exception\DatabaseAccessException;
use League\Csv\Reader;
use League\Csv\Writer;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CsvDataProvider implements DataProviderInterface
{
    private string $dbFile;

    public function __construct(
        private FilesystemOperator $databaseStorage,
        ParameterBagInterface $parameterBag
    ) {
        $this->dbFile = $parameterBag->get('csv_database_file');
    }

    /**
     * @inheritDoc
     */
    public function getList(): array
    {
        $reader = Reader::createFromStream($this->databaseStorage->readStream($this->dbFile));
        $reader->setHeaderOffset(0);
        $recordIterator= $reader->getRecords();

        return array_values(iterator_to_array($recordIterator));

    }

    /**
     * @inheritDoc
     */
    public function commit(array $contextToCommit): void
    {
        $writer = Writer::createFromStream($this->databaseStorage->readStream($this->dbFile));
        $writer->insertAll($contextToCommit);
    }
}