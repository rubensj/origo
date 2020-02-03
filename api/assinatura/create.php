<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db.php';
include_once '../objects/assinatura.php';

$database = new Database();
$db = $database->getConnection();

$assinatura = new Assinatura($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id_cliente) &&
    !empty($data->id_plano)
    ){
        $assinatura->id_cliente = $data->id_cliente;
        $assinatura->id_plano = $data->id_plano;
        
        if($assinatura->create()){
            http_response_code(201);
            echo json_encode(array("message" => "Assinatura cadastrada com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível cadastrar a assinatura."));
        }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível cadastrar a assinatura. Dados incompletos!"));
}
?>