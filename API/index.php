<?php

use Auth\Login;
use Controller\ArticleController\ArticleController;


require_once __DIR__ . '/vendor/autoload.php';
$whoops = new Whoops\Run;
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();
$path = $_SERVER['PATH_INFO'];
if (!isset($path)) {
    $path = '/api';
}

if($path ==='api/users'){
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_decode('{"message":"Hello World users"}');
}
if ($path === '/api') {
    // dump($path);
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // $req = file_get_contents('php://input');
    // $data = json_decode($req, true);
    // if ($data===null) {
    //     echo json_encode([
    //         'error' => 'Bad request'
    //     ]);
    // }else{
    //     echo "<pre>";
    //      print_r($data);
    //     echo "</pre>";
    // }
    //echo json_encode(['message' => 'Hello World from API']);
    // echo password_hash('test123', PASSWORD_DEFAULT);
    echo password_verify('test123','$2y$10$XPIj7KRV5lRUpg8rRfKH6uK6I0X60dmCgFgWD6QA0AF69ZB6SyHTK');
}
// if($path === '/api/test'){
//     header('Access-Control-Allow-Origin: *');
//     header('Content-Type: application/json');
//     header('Access-Control-Allow-Methods: POST');
//     echo json_encode(['message' => 'Hello World from API']);
// }

if ($path === 'api/login') {
    dump($path);
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $login = new Login();
    $login->login();
    $login->verifyToken();
}
// if($path=== 'api/posts'){
//     header('Access-Control-Allow-Origin: *');
//     header('Content-Type: application/json');
//     $post = new ArticleController();
//     $post->getArticles();
// }
