<?php
class Assinatura{
    
    private $conn;
    private $table_name = "assinaturas";
    
    public $id;
    public $id_cliente;
    public $id_plano;
    
    public function __construct($db){
        $this->conn = $db;
    }
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . " a ORDER BY a.id ASC";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        
        return $stmt;
    }
    public function create(){
        $query = "INSERT INTO " . $this->table_name . " SET
                    id_cliente=:id_cliente,
                    id_plano=:id_plano";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->id_plano = htmlspecialchars(strip_tags($this->id_plano));
        
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":id_plano", $this->id_plano);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function readOne(){
        $query = "SELECT * FROM " . $this->table_name . " a WHERE a.id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id_cliente = $row['id_cliente'];
        $this->id_plano = $row['id_plano'];
    }
    public function update(){
        $query = "UPDATE " . $this->table_name . " SET
                id_plano=:id_plano
            WHERE
                id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id_plano = htmlspecialchars(strip_tags($this->id_plano));
        
        $stmt->bindParam(":id_plano", $this->id_plano);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function count(){
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name ;
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'];
    }
    public function isOnlyAssinatura(){
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . "a WHERE a.id_cliente = " . $this->id_cliente;
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row['count']>1) return false;
        return true;
    }
}
?>