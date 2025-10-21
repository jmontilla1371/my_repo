<?php

namespace App\Db;

use ADOConnection;
use Exception;

class Connection
{
    private ADOConnection $conn;

    public function __construct(string $driver, string $dsnOrHost, ?string $user = null, ?string $pass = null)
    {
        $this->conn = \ADONewConnection($driver);
        if ($driver === 'pdo_pgsql') {
            $this->conn->Connect($dsnOrHost, $user, $pass);
        } else {
            // driver 'pgsql'
            $this->conn->Connect($dsnOrHost, $user, $pass);
        }
        $this->conn->SetFetchMode(ADODB_FETCH_ASSOC);
    }

    public function get(): ADOConnection
    {
        return $this->conn;
    }
}
