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

    /**
     * @param array $contextToCommit
     * @throws \App\Infrastracture\Database\DBAL\Exception\DatabaseAccessException
     */
    public function commit(array $contextToCommit):void;
}