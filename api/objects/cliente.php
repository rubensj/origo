<?php
class Cliente{
 
    private $conn;
    private $table_name = "clientes";
 
    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $estado;
    public $cidade;
    public $data_nasc;
    public $assinaturas;
    
    public $id_plano_primeira_assinatura;
 
    public function __construct($db){
        $this->conn = $db;
    }
    
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . " c  ORDER BY c.id ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    public function create(){
        $query = "INSERT INTO " . $this->table_name . " SET 
                    nome=:nome,
                    email=:email,
                    telefone=:telefone, 
                    estado=:estado,
                    cidade=:cidade,
                    data_nasc=:data_nasc";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->cidade = htmlspecialchars(strip_tags($this->cidade));
        $this->data_nasc = htmlspecialchars(strip_tags($this->data_nasc));
        
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":cidade", $this->cidade);
        $stmt->bindParam(":data_nasc", $this->data_nasc);
        
        if($stmt->execute()){
            $last_id = $this->conn->lastInsertId();
            $query = "INSERT INTO assinaturas SET
                    id_cliente=:id_cliente,
                    id_plano=:id_plano";
            
            $stmt_assinatura = $this->conn->prepare($query);
            
            $this->id_plano_primeira_assinatura = htmlspecialchars(strip_tags($this->id_plano_primeira_assinatura));
           
            $stmt_assinatura->bindParam(":id_cliente", $last_id);
            $stmt_assinatura->bindParam(":id_plano", $this->id_plano_primeira_assinatura);
            
            $stmt_assinatura->execute();
            return true;
        }
        return false;
    }
    public function readOne(){
        $query = "SELECT * FROM " . $this->table_name . " c WHERE c.id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $query_assinaturas = "SELECT a.id, a.id_cliente, a.id_plano, p.nome, p.mensalidade FROM assinaturas a, planos p
            WHERE a.id_cliente = ? AND a.id_plano = p.id";
        $stmt_assinaturas = $this->conn->prepare( $query_assinaturas );
        $stmt_assinaturas->bindParam(1, $this->id);
        $stmt_assinaturas->execute();
        
        $assinaturas_array = array();
        
        while ($row_assinaturas = $stmt_assinaturas->fetch(PDO::FETCH_ASSOC)){
            extract($row_assinaturas);
            
            $assinatura_item = array(
                "id" => $id,
                "id_cliente" => $id_cliente,
                "id_plano" => $id_plano
            );
            array_push($assinaturas_array, $assinatura_item);
        }
        
        $this->nome = $row['nome'];
        $this->email = $row['email'];
        $this->telefone = $row['telefone'];
        $this->estado = $row['estado'];
        $this->cidade = $row['cidade'];
        $this->data_nasc = $row['data_nasc'];
        $this->assinaturas = $assinaturas_array;
    }
    public function update(){
        $query = "UPDATE " . $this->table_name . " SET
                nome = :nome,
                email = :email,
                telefone = :telefone,
                estado = :estado,
                cidade = :cidade,
                data_nasc = :data_nasc
            WHERE
                id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->cidade = htmlspecialchars(strip_tags($this->cidade));
        $this->data_nasc = htmlspecialchars(strip_tags($this->data_nasc));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":cidade", $this->cidade);
        $stmt->bindParam(":data_nasc", $this->data_nasc);
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
    public function search($q){
        $query = "SELECT * FROM " . $this->table_name . " c WHERE
                c.nome LIKE ? OR
                c.email LIKE ? OR
                c.telefone LIKE ? OR
                c.estado LIKE ? OR
                c.cidade LIKE ? 
            ORDER BY
                c.id ASC";
        
        $stmt = $this->conn->prepare($query);
        
        $q = htmlspecialchars(strip_tags($q));
        
        $q = "%{$q}%";
        
        $stmt->bindParam(1, $q);
        $stmt->bindParam(2, $q);
        $stmt->bindParam(3, $q);
        $stmt->bindParam(4, $q);
        $stmt->bindParam(5, $q);
        
        $stmt->execute();
        
        return $stmt;
    }
    public function readPaging($from_record_num, $records_per_page){
        $query = "SELECT * FROM " . $this->table_name . " c ORDER BY c.nome ASC LIMIT ?, ?";
        
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
    public function hasFreePlan(){
        $query = "SELECT COUNT(*) as count FROM  assinaturas a WHERE a.id_cliente = ".$this->id." AND a.id_plano = 1" ;
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count']>0;
    }
}
?>