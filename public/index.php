<?php

use Src\Authentication\RonyAuthentication;
use Src\Database\AtikConnection;
use Src\Database\FaiyazQuery;
use Src\Database\RonyConnection;
use Src\Database\RonyQuery;

require_once "../autoload.php";




// include '../src/Database/ShohanConnection.php';
// include '../src/Database/AtikConnection.php';

//$databaseConnectionInstance = new ShohanConnection('localhost', 'stack_faiyaz', 'root', '');

// include '../src/Database/ShohanConnection.php';
// include '../src/Database/AtikConnection.php';
//echo $databaseConnectionInstance = new ShohanConnection('localhost', 'rony', 'root', '');
//$ronyAuth = new RonyAuthentication('localhost', 'root', '', 'rony');

//$databaseConnectionInstanceFromAtik = new AtikConnection('localhost', 'root', '', 'rony');
$objAuth = new RonyAuthentication('localhost', 'root', '', 'rony');
//echo $objAuth->register("users", ["username" => "abdussukkur73@gmail.com", "password" => "pass"]);
//echo $objAuth->updateLimit("users", ["username"=> "RONY", "password" => "PASSWORD"], ["id" => 2], 1);

//Email verification check for register user
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $objAuth->selectLimit("users", ["verified" => 0, "token" => $token], 1);

    if ($result) {
        $update = $objAuth->updateLimit("users", ["verified"=> 1], ["token" => $token], 1);
        if ($update) {
            echo "You account verified successfully";
        }
    } else {
        echo "something wrong. please check your email again...";
    }
}

//echo $objAuth->selectLimit("users", ["username" => "rony", "password" => "ro"], 1);
//$objAuth->insert("uses", ["username" => "rony", "password" => "pass"]);


//$db = $databaseConnectionInstanceFromAtik->getConnection();

// Configure connection parameters.

// databaseConnectionInstance->setMethod
//$databaseConnectionInstanceFromAtik = new AtikConnection('localhost', 'root', '', 'rony');
//$db = $databaseConnectionInstanceFromAtik->getConnection();

//$check_login_logout = new TawfiqueLoginLogout();
