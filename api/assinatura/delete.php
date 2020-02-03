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

if(!empty($data->id)){
    $assinatura->id = $data->id;
    
    $assinatura->readOne();
    
    if($assinatura->isOnlyAssinatura()){
        http_response_code(400);
        echo json_encode(array("message" => "Não foi possível apagar a assinatura. O cliente deve possuir pelo menos uma assinatura!"));
    } else {
        if($assinatura->delete()){
            http_response_code(200);
            echo json_encode(array("message" => "Assinatura foi apagada."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível apagar a assinatura."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível apagar a assinatura. Dados incompletos!"));
}
?>