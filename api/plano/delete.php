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

if(!empty($data->id)){
    $plano->id = $data->id;
    
    if($plano->delete()){
        http_response_code(200);
        echo json_encode(array("message" => "Plano foi apagado."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Não foi possível apagar o plano."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível apagar o plano. Dados incompletos!"));
}
?>