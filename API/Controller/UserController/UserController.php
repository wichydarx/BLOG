<?php

namespace Controller\UserController;


use PDO;
use Model\UserModel;

class UserController
{
   public static function getUser($email)
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $fetchUser = new UserModel();
        
        
        $user = $fetchUser->getUserByEmail($email);
        $num = $user->rowCount();
        if ($num > 0) {
            $users = [];
            $users['data'] = [];
            while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $userData = [
                    'name' => $first_name . ' ' . $last_name,
                    'email' => $email,
                    'role' => $role,
                    'created_at' => $createdAt
                ];
                array_push($users['data'], $userData);
            }
            echo json_encode($users);
            return true;
        } else {
            echo json_encode([
                'error' => 'User not found'
            ]);
        }
    }

    public static function createUser (){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');$requestBody = file_get_contents('php://input');
       if (!empty($requestBody)) {
        $USER = json_decode($requestBody, true);
        foreach ($USER as $key => $value) {
            $USER[$key] = htmlspecialchars(addslashes($value));
        }
       }
        $last_name = $USER->last_name;
        $first_name = $USER->first_name;
        $email = $USER->email;
        $password = $USER->password;
        $confirmPassword = $USER->confirmPassword;
        $newUser = new UserModel();
        $result = $newUser->createUser($last_name, $first_name, $email, $password);
        

        
    }


}
