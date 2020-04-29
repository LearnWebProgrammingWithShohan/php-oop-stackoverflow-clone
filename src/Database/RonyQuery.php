<?php
namespace Src\Database;

use PDO;
use PDOException;

class RonyQuery extends RonyConnection
{
    // Database Data insert method
    public function insert($tableName, array $data)
    {
        try {
            if (is_array($data)) {
                //Build the Dynamic Query
                $columnNames = join(',', array_keys($data));
                $columnValues = ':' . join(', :', array_keys($data));

                //Query and Execute
                $sql = "INSERT INTO $tableName ($columnNames) VALUES ($columnValues)";
                $stmt = $this->connect()->prepare($sql);
                return $stmt->execute($data);
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    // Update Data from Database using where cluse with limit
    public function updateLimit($tableName, array $data, array $where, $limit)
    {
        try {
            if (is_array($data)) {
                $arr = array_combine(
                    array_map(function ($key) {
                        return str_replace($key, $key."=:".$key, $key);
                    }, array_keys($data)),
                    $data
                );

                $whereArr = array_combine(
                    array_map(function ($key) {
                        return str_replace($key, $key."=:".$key, $key);
                    }, array_keys($where)),
                    $where
                );


                // prepare column name for selecting Data
                $columnNames = join(',', array_keys($arr));
                $whereCluse = join(' AND ', array_keys($whereArr));

                $mergeData = $data + $where;
                $sql = "UPDATE $tableName SET $columnNames WHERE ($whereCluse) LIMIT $limit";
                
                $stmt = $this->connect()->prepare($sql);
                return $stmt->execute($mergeData);
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    // Update Data from Database using where cluse
    public function updateAll($tableName, array $data, array $where, $limit)
    {
        try {
            if (is_array($data)) {
                $arr = array_combine(
                    array_map(function ($key) {
                        return str_replace($key, $key."=:".$key, $key);
                    }, array_keys($data)),
                    $data
                );

                $whereArr = array_combine(
                    array_map(function ($key) {
                        return str_replace($key, $key."=:".$key, $key);
                    }, array_keys($where)),
                    $where
                );


                // prepare column name for selecting Data
                $columnNames = join(',', array_keys($arr));
                $whereCluse = join(' AND ', array_keys($whereArr));

                $mergeData = $data + $where;
                $sql = "UPDATE $tableName SET $columnNames WHERE ($whereCluse) LIMIT $limit";
                
                $stmt = $this->connect()->prepare($sql);
                return $stmt->execute($mergeData);
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }


    // Select Data from Database with conditions and limit
    public function selectLimit($tableName, array $selectData, $limit)
    {
        try {
            if (is_array($selectData)) {

                // prepare array key following SQL syntax
                $arr = array_combine(
                    array_map(function ($key) {
                        return str_replace($key, $key."=:".$key, $key);
                    }, array_keys($selectData)),
                    $selectData
                );

                // prepare column name for selecting Data
                $columnNames = join(' AND ', array_keys($arr));

                $sql = "SELECT * FROM $tableName WHERE $columnNames LIMIT $limit";
                
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute($selectData);
                if ($limit == 1) {
                    return $stmt->fetch();
                } else {
                    return $stmt->fetchAll();
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
