<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\DBAL\CsvDBAL;

use App\Infrastructure\Database\DBAL\Api\DataProviderInterface;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CsvDataProvider implements DataProviderInterface
{
    private string $dbFilePath;

    public function __construct(
        ParameterBagInterface $parameterBag
    ) {
        $this->dbFilePath = $parameterBag->get('csv_database_path');
    }

    /**
     * @inheritDoc
     */
    public function getList(): array
    {
        $reader = Reader::createFromPath($this->dbFilePath);
        $reader->setHeaderOffset(0);
        $recordIterator= $reader->getRecords();

        return array_values(iterator_to_array($recordIterator));

    }

    /**
     * @inheritDoc
     */
    public function commit(array $contextToCommit): void
    {
        $writer = Writer::createFromPath($this->dbFilePath,'a');
        $writer->insertAll($contextToCommit);
    }
}
