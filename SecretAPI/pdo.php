<?php
class DB {
    private $servername = "localhost";
    private $username = "root";
    private $password = NULL;
    private $dbname = "secret_server";

    protected function connect() {
        // Set PDO attributes and perform additional configurations if needed
        $_pdo = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        $_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $_pdo;
    }
}
?>