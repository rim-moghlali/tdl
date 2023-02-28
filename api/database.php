<?php

class Database {
    
    private $db_hostname = "localhost";
    private $db_port = 3307;
    private $db_username = "root";
    private $db_password = "";
    private $db_database = "tdl";

    protected $pdo;


    public function dbConnexion()
    {
        try {

            $this->pdo = new PDO("mysql:host=$this->db_hostname;port=$this->db_port;dbname=$this->db_database", $this->db_username, $this->db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "[database] (PDO): Connected successfully";

        } catch (PDOException $e) {
            echo "[database] (PDO): Connection is failed " . $e->getMessage();
            exit;
        }


    }


}

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}





?>