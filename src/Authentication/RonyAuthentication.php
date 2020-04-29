<?php
namespace Src\Authentication;

use Exception;
use PDOException;
use Src\Database\RonyConnection;
use Src\Database\RonyQuery;

class RonyAuthentication extends RonyQuery
{
    // User Registraion method
    public function register($tableName, array $registrationInfo)
    {
        try {
            if (is_array($registrationInfo)) {
                //Check if user alreay Exist
                if ($this->checkIfUserAlreadyExists($tableName, "username", $registrationInfo['username']) == true) {
                    throw new Exception("User Name Alreay Exists");
                }

                // password hasing
                $registrationInfo['password'] = password_hash($registrationInfo['password'], PASSWORD_DEFAULT);
                $token = bin2hex(random_bytes(50));
                $regInfo = array_merge($registrationInfo, ["token"=>"$token"]);

                // User info insert into Databse
                if ($this->insert($tableName, $regInfo)) {
                    $this->sendEmail($registrationInfo['username'], $token);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function login($tableName, array $data)
    {
        try {
            if (is_array($data)) {
                $loginData = $this->selectLimit($tableName, $data, 1);
                if ($loginData) {
                    if ($loginData["verified"] == 1) {
                        $this->loginSession();
                        $this->setAuthenticate($loginData['username']);
                    } else {
                        throw new Exception("This Account has not been verified yet");
                    }
                } else {
                    throw new Exception("User name or Password is incorrect");
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkIfUserAlreadyExists($tableName, $columnName, $userName)
    {
        if ($this->selectLimit($tableName, [$columnName=>$userName], 1)) {
            return true;
        }
        return false;
    }

    public function sendEmail($to, $token)
    {
        $to = $to;
        $subject = "Email Verification";
        $message = "<p>For active you account click the <a href='http://localhost/php-oop-stackoverflow-clone/public
    /RonyIndex.php?token=$token'>link</a></p>";
        $headers = "MIME-Version: 1.0 \r\n";
        $headers.= "Content-type:text/html;charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "Please check your eamil for verify your account";
        }
    }

    public function loginSession()
    {
        session_start();
        $_SESSION['loggedin'] = false;
        $_SESSION['username'] = false;
    }

    public function setAuthenticate($usename)
    {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $usename;
        return true;
    }

    public function logout()
    {
        unset($_SESSION['loggedin']);
        unset($_SESSION['username']);
        session_destroy();
    }

    public function getAuthenticatedUser()
    {
        return $_SESSION['username'];
    }
}
