<?php

namespace App\Infrastracture\Database\DBAL\Api;

interface EntityManagerFactoryInterface
{
    public function create():EntityManagerInterface;
}