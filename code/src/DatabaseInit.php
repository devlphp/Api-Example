<?php
declare(strict_types=1);

namespace ApiExample;

class DatabaseInit
{
    public function __construct(private readonly string $host,
                                private readonly string $db_name,
                                private readonly string $user,
                                private readonly string $password,
                                private readonly string $port)
    {

    }

    public function getPDO(): \PDO
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8";

        return new \PDO($dsn, $this->user, $this->password, [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_STRINGIFY_FETCHES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }
}