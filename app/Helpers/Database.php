<?php

namespace App\Helpers;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private Capsule $connection;

    public function __construct()
    {
        $this->connection = new Capsule;
        $this->connection->addConnection([
            'driver' => DBDRIVER,
            'host' => DBHOST,
            'database' => DBNAME,
            'username' => DBUSER,
            'password' => DBPASS,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $this->connection->setAsGlobal();
        $this->connection->bootEloquent();
    }

    /**
     * @param string $filePath
     */
    public function importSql(string $filePath)
    {
        $this->connection->getConnection()->unprepared(file_get_contents($filePath));
    }

}