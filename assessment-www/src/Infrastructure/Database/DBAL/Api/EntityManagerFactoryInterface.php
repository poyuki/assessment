<?php

namespace App\Infrastructure\Database\DBAL\Api;

interface EntityManagerFactoryInterface
{
    public function create():EntityManagerInterface;
}