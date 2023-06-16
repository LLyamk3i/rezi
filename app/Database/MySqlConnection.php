<?php

declare(strict_types=1);

namespace App\Database;

use Illuminate\Database\MySqlConnection as DatabaseMySqlConnection;

final class MySqlConnection extends DatabaseMySqlConnection
{
    protected $fetchMode = \PDO::FETCH_ASSOC;
}
