<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../objects/cliente.php';

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

$stmt = $cliente->read();
$num = $stmt->rowCount();

if($num>0){

    $clientes_array = array();
    $clientes_array["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $cliente_item = array(
            "id" => $id,
            "nome" => $nome,
            "email" => $email,
            "telefone" => $telefone,
            "estado" => $estado,
            "cidade" => $cidade,
            "data_nasc" => date('d/m/Y', strtotime($data_nasc)),
            "assinaturas" => array($cliente->assinaturas)
        );
        array_push($clientes_array["records"], $cliente_item);
    }
    http_response_code(200);
    
    echo json_encode($clientes_array);
} else {
    http_response_code(404);
    
    echo json_encode(array("message" => "Nenhum cliente encontrado."));
}