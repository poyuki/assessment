<?php

declare(strict_types=1);

namespace App\Infrastracture\Database\DBAL\JsonDBAL;

use App\Infrastracture\Database\DBAL\Api\DataProviderInterface;
use App\Infrastracture\Database\DBAL\Exception\DatabaseAccessException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JsonDataProvider implements DataProviderInterface
{
    private string $dbFilePath;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->dbFilePath = $parameterBag->get('json_database_path');
    }

    /**
     * @return array
     * @throws DatabaseAccessException
     */
    public function getList(): array
    {
        try {
            return json_decode(file_get_contents($this->dbFilePath), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new DatabaseAccessException($e->getMessage(), $e->getCode(), $e);
        }
    }
}