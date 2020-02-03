<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../objects/plano.php';

$database = new Database();
$db = $database->getConnection();

$plano = new Plano($db);

$stmt = $plano->read();
$num = $stmt->rowCount();

if($num>0){
    $planos_array = array();
    $planos_array["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $plano_item=array(
            "id" => $id,
            "nome" => $nome,
            "mensalidade" => $mensalidade
        );
        
        array_push($planos_array["records"], $plano_item);
    }
    
    http_response_code(200);
    echo json_encode($planos_array);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Nenhum plano encontrado."));
}
?>