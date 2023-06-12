<?php

namespace Model;

use Config\Database\Database;


require_once  '../../vendor/autoload/autoload.php';


abstract class Model
{
    protected $pdo;
    protected $table;

    public function __construct(){
        $pdo =new  Database();
        $this->pdo = $pdo->connect();

    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return  $stmt;

    }

    public function getById($id){
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return  $stmt;
    }

    public function delete ($id){
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()){
            return true;
        }else{
            $error = $stmt->errorInfo();
            printf("Error: %s.\n", $error[2]);
            return false;
        }
        
    }
}
