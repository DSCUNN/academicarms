<?php 
namespace Php;

class Validation  
{

    //validate post data
    public function run($data = [])
    {  

        $message = null;
        $token   = false;

        //server requiest post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //check _token 
            if ($data['_token'] !== $_SESSION['_token']) {
                $message .= "<li>Mismatch token!</li>";
            } else {
                //set token is true
                $token = true;
            }

            // validation for each posted data
            $database = $this->filterInput('Database Name', $data['database']);
            $username = $this->filterInput('Username', $data['username']);
            $password = $this->filterPassword('Password', $data['password']);
            $hostname = $this->requiredInput('Host Name', $data['hostname']);
            $paystack_private = $this->filterInput('Paystack Private Key', $data['paystack_private']);
            $paystack_public = $this->filterInput('Paystack Public Key', $data['paystack_public']);
            $flutter_public = $this->filterInput('Flutterwave Public Key', $data['flutter_public']);
            $flutter_private = $this->filterInput('Flutterwave Secret Key', $data['flutter_private']);
            $environ = $this->filterInput('Development Environment', $data['environ']);

            //if $database, $username, $password and $hostname contain string data then set it as error message
            if (is_string($database)) {
                $message .= "<li>$database</li>";
            }
            if (is_string($username)) {
                $message .= "<li>$username</li>";
            }
            if (is_string($password)) {
                $message .= "<li>$password</li>";
            }
            if (is_string($hostname)) {
                $message .= "<li>$hostname</li>";
            }
            if (is_string($flutter_public)) {
                $message .= "<li>$flutter_public</li>";
            }
            if (is_string($flutter_private)) {
                $message .= "<li>$flutter_private</li>";
            }
            if (is_string($paystack_private)) {
                $message .= "<li>$paystack_private</li>";
            }
            if (is_string($paystack_public)) {
                $message .= "<li>$paystack_public</li>";
            }
            if (is_string($environ)) {
                $message .= "<li>$environ</li>";
            }

            //if return true 
            if ($database === true 
                && $username === true 
                && $password === true 
                && $hostname === true
                && $paystack_private === true
                && $paystack_public === true
                && $flutter_private === true
                && $flutter_public === true
                && $environ === true
                && $token    === true
            ) { 
                return true;
            } 

        } else {
            $message .= "<li>Please fillup all required fields*</li>";
        }
        return $message;
    }


    //filter all input data
    public function filterInput($title = null, $data = null)
    { 
        //if not empty posted data
        if (!empty($data)) { 
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            // check if name only contains letters and numbers
            if (!preg_match("/^[A-Za-z0-9_-]+$/", $data)) {
                return "{$title} can only have alphabet, numbers and underscores";
            }else{
                //check first letter is number
                if (is_numeric(substr($data, 0, 1))) {
                    return "{$title} first letter must be a character";
                } else {
                    //if first letter is character
                    return true;
                }
            }   
        } else {
            return "$title is required";
        }
    } 


    //filter all input data
    public function requiredInput($title = null, $data = null)
    { 
        //if not empty posted data
        if (!empty($data)) {  
                return true;
        } else {
            return "$title is required";
        }
    } 

    //filter password with $title and $data
    public function filterPassword($title = null, $data = null)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);  

        //check passwod containt <script> tag
        if (preg_match('<script>', $data)) {
            return "{$title} contains script tag";
        } else {
            return true;
        }
    }


    //check file exists
    public function checkFileExists($file_path = null)
    {
        //check file is exists
        if (file_exists($file_path)) {
            return true;
        } else {
            return false;
        }
    }

    //check .env file exists in Flag direcotry
    public function checkEnvFileExists()
    {
        //check flag/env file is exists
        if (file_exists('flag/env')) {
            //create application launch url
            $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
            $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
            $root = str_replace('/install/', '', $root);
            //redirect to application
            header('location: '.$root);
        } else {
            //if env file is not exists in sql directory
            return false;
        }
    } 

}