<?php

// use Src\Database\AtikConnection;
use Src\Database\durjoiDB;

require_once "../autoload.php";
// include '../src/Database/ShohanConnection.php';
// include '../src/Database/AtikConnection.php';
print_r($db = durjoiDB::getInstance()->get('users', ['id', '=', '6'])->first());
//$databaseConnectionInstance = new ShohanConnection('localhost', 'stack_faiyaz', 'root', '');

// include '../src/Database/ShohanConnection.php';
// include '../src/Database/AtikConnection.php';
//echo $databaseConnectionInstance = new ShohanConnection('localhost', 'rony', 'root', '');

// $databaseConnectionInstanceFromAtik = new AtikConnection('localhost', 'root', '', 'rony');
//$db = $databaseConnectionInstanceFromAtik->getConnection();

// Configure connection parameters.

// databaseConnectionInstance->setMethod
//$databaseConnectionInstanceFromAtik = new AtikConnection('localhost', 'root', '', 'rony');
//$db = $databaseConnectionInstanceFromAtik->getConnection();

//$check_login_logout = new TawfiqueLoginLogout();
