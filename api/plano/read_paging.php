<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/db.php';
include_once '../shared/utilities.php';
include_once '../objects/plano.php';

$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$plano = new Plano($db);

$stmt = $plano->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

if($num>0){
    
    $planos_array = array();
    $planos_array["records"] = array();
    $planos_array["paging"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $plano_item = array(
            "id" => $id,
            "nome" => $nome,
            "mensalidade" => $mensalidade,
        );
        array_push($planos_array["records"], $plano_item);
    }

    $total_rows = $plano->count();
    $page_url = "{$home_url}plano/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $planos_array["paging"] = $paging;
    
    http_response_code(200);
    
    echo json_encode($planos_array);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Sem planos para exibir."));
}
?>