<?php

namespace Auth;


use Exception;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Controller\UserController\UserController;

class Login
{
    private $secretKey;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(dirname(__FILE__)) . '../../');
        $dotenv->load();
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
    }

    public function login()
    {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestBody = file_get_contents('php://input');
            if (!empty($requestBody)) {
                 $userInfo = json_decode($requestBody, true);
                foreach ($userInfo as $key => $value) {
                    $userInfo[$key] = htmlspecialchars(addslashes($value));
                }
            }
            
            $email = $userInfo['email'] ?? '';
            $password = password_hash($userInfo['password'], PASSWORD_DEFAULT) ?? '';
           

            if (empty($email)) {
                echo json_encode([
                    'error' => 'Email is required'
                ]);
                return;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode([
                    'error' => 'The email address must be a valid email address'
                ]);
                return;
            }

            if (empty($password)) {
                echo json_encode([
                    'error' => 'Password is required'
                ]);
                return;
            }

            $user = UserController::getUser($email);

            if (!$user) {
                echo json_encode([
                    'error' => 'User not found'
                ]);
                return;
            }

            $emailFromDb = $user['email'];
            $passwordFromDb = $user['password'];

            if (password_verify($password, $passwordFromDb) && $emailFromDb === $email) {
               
                $payload = [
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'iss' => 'localhost',
                    'aud' => 'localhost',
                    'data' => [
                        'lastname' => $user['last_name'],
                        'firstname' => $user['first_name'],
                        'role' => $user['role'],
                        'email' => $email
                    ]

                ];

                
                $token = JWT::encode($payload, $this->secretKey, 'HS256');

                
                setcookie('auth_token', $token, time() + 3600, '/', 'localhost', false, true);
                
                $responseData = [
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'email' => $email,
                    ],
                ];
                header('Content-Type: application/json');
                echo json_encode($responseData);
                return;
            }

            
            $responseData = [
                'success' => false,
                'message' => 'Invalid credentials',
            ];
            header('Content-Type: application/json', true, 401);
            echo json_encode($responseData);
            return;
        }
    }


    public function verifyToken()
    {
        
        if (isset($_COOKIE['auth_token'])) {
            
            try {
                $decodedToken = JWT::decode($_COOKIE['auth_token'], $this->secretKey);

                
                $currentTime = time();
                if ($decodedToken->exp < $currentTime) {
                    
                    $responseData = [
                        'success' => false,
                        'message' => 'Token has expired',
                    ];
                    header('Content-Type: application/json', true, 401);
                    echo json_encode($responseData);
                    exit;
                }

                
                $userEmail = $decodedToken->email;

                $userExists = UserController::getUser($userEmail);

                if (!$userExists) {
                    
                    $responseData = [
                        'success' => false,
                        'message' => 'User does not exist',
                    ];
                    header('Content-Type: application/json', true, 401);
                    echo json_encode($responseData);
                    exit;
                }


                
                $responseData = [
                    'success' => true,
                    'message' => 'Authenticated user',
                    'user' => [
                        'firstname' => $decodedToken->data['first_name'],
                        'lastname' => $decodedToken->data['last_name'],
                        'role' => $decodedToken->data['role'],
                        'email' => $decodedToken->data['email']
                    ],
                ];
                header('Content-Type: application/json');
                echo json_encode($responseData);
                exit;
            } catch (Exception $e) {
               
                $responseData = [
                    'success' => false,
                    'message' => 'Token validation failed',
                ];
                header('Content-Type: application/json', true, 401);
                echo json_encode($responseData);
                exit;
            }
        } else {
           
            $responseData = [
                'success' => false,
                'message' => 'Unauthorized',
            ];
            header('Content-Type: application/json', true, 401);
            echo json_encode($responseData);
            exit;
        }
    }
}
