<?php

namespace App\Base;

use App\Model\Interfaces\Database;

abstract class BaseManager
{
    protected \PDO $pdo;
    public function __construct(Database $database)
    {
        $this->pdo = $database->getMySqlPDO();
    }

}