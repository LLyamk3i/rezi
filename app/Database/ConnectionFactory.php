<?php

declare(strict_types=1);

namespace App\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SqlServerConnection;
use Illuminate\Database\Connectors\ConnectionFactory as DatabaseConnectionFactory;

final class ConnectionFactory extends DatabaseConnectionFactory
{
    /**
     * Create a new connection instance.
     *
     * @param string              $driver
     * @param \PDO|\Closure       $connection
     * @param string              $database
     * @param string              $prefix
     * @param array<string,mixed> $config
     *
     * @return \Illuminate\Database\Connection
     *
     * @throws \InvalidArgumentException
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ((bool) ($resolver = Connection::getResolver($driver))) {
            return $resolver($connection, $database, $prefix, $config);
        }

        return match ($driver) {
            'mysql' => new MySqlConnection($connection, $database, $prefix, $config),
            'pgsql' => new PostgresConnection($connection, $database, $prefix, $config),
            'sqlite' => new SQLiteConnection($connection, $database, $prefix, $config),
            'sqlsrv' => new SqlServerConnection($connection, $database, $prefix, $config),
            default => throw new \InvalidArgumentException("Unsupported driver [{$driver}]."),
        };
    }
}
