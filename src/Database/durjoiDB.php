<?php
namespace Src\Database;

use Config\Env;
use PDO;

class durjoiDB {
      private static $instance = null;
      private $_query,
              $_pdo,
              $_error = false,
              $_results,
              $_count = 0;


      final private function __construct() {
        try {
          $this->_pdo = new PDO('mysql:host='.Env::get('mysql/host').';dbname='.Env::get('mysql/db'),Env::get('mysql/username'),Env::get('mysql/password'));
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
      }

      final private function __clone() {
        return self::$instance;
      }

      public static function getInstance() {
        if(!isset(self::$instance)) {
          self::$instance = new durjoiDB;
        }
        return self::$instance;
      }

      private function query($sql, $params = []) {
        $this->_error = false;

        if($this->_query = $this->_pdo->prepare($sql)) {
          $x = 1;
          if(count($params)) {
            foreach ($params as $param) {
              $this->_query->bindValue($x, $param);
              $x++;
            }
          }

          if($this->_query->execute()) {
            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->_count = $this->_query->rowCount();
          } else {
            $this->_error = true;
          }
        }
        return $this;
      }

      public function action($action, $table, $where = []) {
        if(count($where) === 3) {
          $operators = ['=', '<', '>', '<=', '>='];
          $field = $where[0];
          $operator = $where[1];
          $value = $where[2];

          if(in_array($operator, $operators)) {
            $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
            if(!$this->query($sql, [$value])->error()) {
              return $this;
            }
          }
        }
        return false;
      }

      public function insert($table, $fields = []) {
        if(count($fields)) {
          $keys = array_keys($fields);
          $values = null;
          $x = 1;

          foreach($fields as $field) {
            $values .= '?';
            if($x < count($fields)) {
              $values .= ', ';
            }
            $x++;
          }
          $sql = "INSERT INTO {$table} (`". implode('`, `', $keys) ."`) VALUES ({$values})";
          if(!$this->query($sql, $fields)->error()) {
            return true;
          }
        }
        return false;
      }

      public function update($table, $id, $fields = []) {
        $set = "";
        $x = 1;

        foreach($fields as $name => $value) {
          $set .= "{$name} = ?";
          if($x < count($fields)) {
            $set .= ", ";
          }
          $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = $id";

        if(!$this->query($sql, $fields)->error()) {
          return true;
        }
        return false;

      }

      public function get($table, $where = []) {
        return $this->action('SELECT *', $table, $where);
      }

      public function delete($table, $where = array()) {
        return $this->action('DELETE', $table, $where);
      }

      public function results() {
        return $this->_results;
      }
      public function count() {
        return $this->_count;
      }
      public function error() {
        return $this->_error;
      }
      public function first() {
        return $this->results()[0];
      }
    }
 ?>
