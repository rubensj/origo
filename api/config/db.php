<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $schema = "teste_origo";
    private $usr = "root";
    private $pass = "";
    public $conn;
 
    public function getConnection(){
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->schema.";charset=utf8",
                $this->usr,
                $this->pass);
        }catch(PDOException $exception){
            echo "Erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>