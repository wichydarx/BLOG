<?php

namespace Model;

use Model\Model;

class UserModel extends Model
{

    protected $table = 'users';
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()){
            return $stmt;
        }else{
            $error = $stmt->errorInfo();
            printf("Error: %s.\n", $error[2]);
            return false;
        }
       
    }

    public function createUser($last_name, $first_name, $email, $password)
    {
        $query = "INSERT INTO $this->table (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            printf("Error: %s.\n", $error[2]);
            return false;
        }
    }


    public function updateUserInfo( $last_name, $first_name, $email)
    {
        $query = "UPDATE $this->table SET last_name = :last_name, first_name = :first_name, email = :email WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            printf("Error: %s.\n", $error[2]);
            return false;
        }
    }

    public function updateUserPassword ($userEmail, $password){
        $query = "UPDATE $this->table SET password = :password WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $userEmail);
        $stmt->bindParam(':password', $password);
        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            printf("Error: %s.\n", $error[2]);
            return false;
        }
    }
}
