<?php

use Src\Authentication\RonyAuthentication;
use Src\Database\AtikConnection;
use Src\Database\FaiyazQuery;
use Src\Database\RonyConnection;
use Src\Database\RonyQuery;

require_once "../autoload.php";


$objAuth = new RonyAuthentication('localhost', 'root', '', 'rony');
//echo $objAuth->register("users", ["username" => "abdussukkur73@gmail.com", "password" => "pass"]);
//echo $objAuth->updateLimit("users", ["username"=> "RONY", "password" => "PASSWORD"], ["id" => 2], 1);

//Email verification check for register user
// if (isset($_GET['token'])) {
//     $token = $_GET['token'];
//     $result = $objAuth->selectLimit("users", ["verified" => 0, "token" => $token], 1);

//     if ($result) {
//         $update = $objAuth->updateLimit("users", ["verified"=> 1], ["token" => $token], 1);
//         if ($update) {
//             echo "You account verified successfully";
//         }
//     } else {
//         echo "something wrong. please check your email again...";
//     }
// }

echo $objAuth->login("users", ["username" => "soni", "password" => "soni"]);
