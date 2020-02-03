<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db.php';
include_once '../objects/cliente.php';

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    $cliente->id = $data->id;
    
    $cliente->readOne();
    
    if($cliente->estado == "São Paulo" && $cliente->hasFreePlan()){
        http_response_code(400);
        echo json_encode(array("message" => "Não foi possível apagar o cliente. Clientes do plano FREE, do estado de São Paulo, não podem ser excluídos!"));
    } else {
        if($cliente->delete()){
            http_response_code(200);
            echo json_encode(array("message" => "Cliente foi apagado."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível apagar o cliente."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível apagar o cliente. Dados incompletos!"));
}
?>