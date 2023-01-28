<?php

namespace App\Model\Factory;

use App\Model\Interfaces\Database;

class PDO implements Database
{
private string $host;
private string $dbName;
private string $username;
private string $password;

public function __construct(string $host = "db", string $dbName = "colo_count", string $username = "root", string $password = "password")
{
$this->host = $host;
$this->dbName = $dbName;
$this->username = $username;
$this->password = $password;
}

public function getMySqlPDO(): \PDO
{
return new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password);
}
}