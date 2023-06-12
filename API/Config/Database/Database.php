<?php
namespace Config\Database;

use Dotenv\Dotenv;

class Database
{
private $dsn;
private $dbName;
private $dbUser;
private $dbPassword;

public function __construct()
{
$dotenv = Dotenv::createImmutable(dirname(dirname(__FILE__)) . '/../../');
$dotenv->load();
$this->dsn = $_ENV['DB_DSN'];
$this->dbName = $_ENV['DB_NAME'];
$this->dbUser = $_ENV['DB_USER'];
$this->dbPassword = $_ENV['DB_USER_PASSWORD'];
}

public function connect()
{
try {
$pdo = new \PDO($this->dsn, $this->dbUser, $this->dbPassword);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE DATABASE IF NOT EXISTS $this->dbName");
$pdo->exec("USE $this->dbName");
return $pdo;
} catch (\PDOException $e) {
if ($_ENV['APP_ENV'] == 'production') {
return json_encode([
'error' => "An error has occurred. Please verify the database connection information."
]);
} else {
return json_encode([
'error' => $e->getMessage()
]);
}
}
}
}