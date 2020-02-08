<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use Exception;

class Database {
    private PDO $connection;

    public function __construct(string $driver, string $host, string $username, string $password, int $port, string $dbName)
    {
        if ($driver === 'pdo_mysql') {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbName;port=$port", $username, $password);
        }

        if (!$this->connection) {
          throw new Exception('Unable to establish database connection...');
        }
    }
}