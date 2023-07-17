<?php

declare(strict_types=1);

namespace App\Database;

use Illuminate\Database\SQLiteConnection as DatabaseSQLiteConnection;

final class SQLiteConnection extends DatabaseSQLiteConnection
{
    protected $fetchMode = \PDO::FETCH_ASSOC;
}
