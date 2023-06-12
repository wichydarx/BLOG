<?php
require_once "C:\Users\WICHY DARXWATR\Desktop\DWWM4\BACK_END\BLOG\API\\vendor\autoload.php";

use Auth\Login;

// require_once './Auth/Login.php';

// use Auth\Login;



// require "./API/Auth/Login.php";
// require './Auth/Login.php';
// $whoops = new Whoops\Run;
// $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
// $whoops->register();

$login = new Login();
$login->login();
$login->verifyToken();
