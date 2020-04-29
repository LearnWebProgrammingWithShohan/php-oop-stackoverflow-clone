<?php
namespace Src\Database;

use Exception;
use PDO;

class RonyConnection
{
    protected $db;
    private $hostname;
    private $username;
    private $password;
    private $database;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        $dsn = "mysql:host={$this->hostname};
                dbname={$this->database};";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, # convert error to exception
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC   # set default fetch mode associative array
        ];

       
        $pdo = new PDO($dsn, $this->username, $this->password, $options);
        return $pdo;
    }
}
