<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/db.php';
include_once '../objects/cliente.php';

$database = new Database();
$db = $database->getConnection();
 
$cliente = new Cliente($db);
 
$cliente->id = isset($_GET['id']) ? $_GET['id'] : die();

$cliente->readOne();
 
if($cliente->nome!=null){
    $cliente_array = array(
        "id" =>  $cliente->id,
        "nome" => $cliente->nome,
        "email" => $cliente->email,
        "telefone" => $cliente->telefone,
        "estado" => $cliente->estado,
        "cidade" => $cliente->cidade,
        "data_nasc" => date('Y-m-d', strtotime($cliente->data_nasc)),
        "assinaturas" => array($cliente->assinaturas)
    );
    http_response_code(200);
    echo json_encode($cliente_array);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Cliente não encontrado."));
}
?>