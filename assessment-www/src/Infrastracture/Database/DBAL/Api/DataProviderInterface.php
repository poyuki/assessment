<?php

namespace App\Infrastracture\Database\DBAL\Api;

use App\Infrastracture\Database\DBAL\Exception\DatabaseAccessException;

interface DataProviderInterface
{
    /**
     * @return array
     * @throws DatabaseAccessException
     */
    public function getList(): array;
}