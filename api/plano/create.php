<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db.php';
include_once '../objects/plano.php';
 
$database = new Database();
$db = $database->getConnection();
 
$plano = new Plano($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(!empty($data->nome) &&
    !empty($data->mensalidade) 
){
    $plano->nome = $data->nome;
    $plano->mensalidade = $data->mensalidade;

    if($plano->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Plano cadastrado com sucesso."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Não foi possível cadastrar o plano."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível cadastrar o plano. Dados incompletos!"));
}
?>