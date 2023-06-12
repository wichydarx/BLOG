<?php

namespace Config\Database;

use Dotenv\Dotenv;

class Database
{

    private String $dsn;
    private String $dbName;
    private String $dbUser;
    private String $dbPassword;

    public function __construct(){
        $dotenv = Dotenv::createImmutable(dirname(dirname(__FILE__)) . '/../../');
        $dotenv->load();
        $this->dsn = $_ENV['DB_DSN'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPassword = $_ENV['DB_USER_PASSWORD'];
    }

    public  function connect(){
        try{
            $pdo = new \PDO($this->dsn.$this->dbName, $this->dbUser, $this->dbPassword);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $db = " SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :schema_name";
            $stmt = $pdo->prepare($db);
            $stmt->bindParam(':schema_name', $this->dbName);
            $stmt->execute();
            $dbExist = $stmt->fetchColumn();
            if (!$dbExist){
                $sql = "CREATE DATABASE $this->dbName";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt){
                    echo "Database created";
                }
            }
            return $pdo;  
        } catch (\PDOException $e){
            if($_ENV['APP_ENV'] == 'production'){
                return json_encode([
                    'error' => "An error has occurred try verify the informations."
                ]);
            } else {
                return json_encode([
                    'error' => $e->getMessage()
                ]);
            }
        }
    }


}
