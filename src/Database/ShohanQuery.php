<?php
namespace Src\Database;

use src\Database\ShohanConnection;

class ShohanQuery extends ShohanConnection
{
    public function basicQuery($tableName)
    {
        //return $this->connection->query("SELECT * FROM POSTS");

        $stmt = $this->connection->query("SELECT * FROM POSTS");

        $stmt->bindParam(":tableName", $tableName);

        $stmt->execute();
    }
}
