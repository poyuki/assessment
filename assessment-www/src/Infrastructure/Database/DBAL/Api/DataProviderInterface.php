<?php

namespace App\Infrastructure\Database\DBAL\Api;

use App\Infrastructure\Database\DBAL\Exception\DatabaseAccessException;

interface DataProviderInterface
{
    /**
     * @return array
     * @throws DatabaseAccessException
     */
    public function getList(): array;

    /**
     * @param array $contextToCommit
     * @throws \App\Infrastructure\Database\DBAL\Exception\DatabaseAccessException
     */
    public function commit(array $contextToCommit):void;
}