<?php
class Plano{

    private $conn;
    private $table_name = "planos";
    
    public $id;
    public $nome;
    public $mensalidade;
    
    public function __construct($db){
        $this->conn = $db;
    }
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . " p ORDER BY p.mensalidade ASC";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        
        return $stmt;
    }
    public function create(){
        $query = "INSERT INTO " . $this->table_name . " SET
                    nome=:nome,
                    mensalidade=:mensalidade";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->mensalidade = str_replace(",", ".", htmlspecialchars(strip_tags($this->mensalidade)));
            
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":mensalidade", $this->mensalidade);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function readOne(){
        $query = "SELECT * FROM " . $this->table_name . " p WHERE p.id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nome = $row['nome'];
        $this->mensalidade = $row['mensalidade'];
    }
    public function update(){
        $query = "UPDATE " . $this->table_name . " SET
                nome = :nome,
                mensalidade = :mensalidade,
            WHERE
                id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->mensalidade = str_replace(",", ".", htmlspecialchars(strip_tags($this->mensalidade)));
            
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":mensalidade", $this->mensalidade);
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
    public function search($nome, $min, $max){
        $query = "SELECT * FROM " . $this->table_name . " p WHERE
                p.nome LIKE ? AND
                p.mensalidade >= ? AND
                p.mensalidade <= ?
            ORDER BY
                p.mensalidade ASC";
        
        $stmt = $this->conn->prepare($query);
        
        $nome = htmlspecialchars(strip_tags($nome));
        $min = htmlspecialchars(strip_tags($min));
        $max = htmlspecialchars(strip_tags($max));
            
        $nome = "%{$nome}%";
        
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $min);
        $stmt->bindParam(3, $max);
        
        $stmt->execute();
        
        return $stmt;
    }
    public function readPaging($from_record_num, $records_per_page){
        $query = "SELECT * FROM " . $this->table_name . " p ORDER BY p.mensalidade ASC LIMIT ?, ?";
        
        $stmt = $this->conn->prepare( $query );
        
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt;
    }
    public function count(){
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name ;
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'];
    }
    public function getMaxMensalidade(){
        $query = "SELECT MAX(mensalidade) as max FROM " . $this->table_name ;
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['max'];
    }
}
?>