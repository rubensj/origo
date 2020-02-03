<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/db.php';
include_once '../objects/plano.php';

$database = new Database();
$db = $database->getConnection();
 
$plano = new Plano($db);
 
$plano->id = isset($_GET['id']) ? $_GET['id'] : die();

$plano->readOne();
 
if($plano->nome!=null){
    $plano_array = array(
        "id" =>  $plano->id,
        "nome" => $plano->nome,
        "mensalidade" => $plano->mensalidade,
    );
    http_response_code(200);
    echo json_encode($plano_array);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Plano não encontrado."));
}
?>