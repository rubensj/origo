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
if(!empty($data->nome) &&
    !empty($data->email) &&
    !empty($data->telefone) &&
    !empty($data->estado) &&
    !empty($data->cidade) &&
    !empty($data->data_nasc)
    ){

    $cliente->id = $data->id;
    
    $cliente->nome = $data->nome;
    $cliente->email = $data->email;
    $cliente->telefone = $data->telefone;
    $cliente->estado = $data->estado;
    $cliente->cidade = $data->cidade;
    $cliente->data_nasc = $data->data_nasc;
    
    if($cliente->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Dados do cliente atualizados com sucesso."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Não foi possível atualizar os dados do cliente!"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível atualizar o cliente. Dados incompletos!"));
}
?>