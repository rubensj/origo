<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/db.php';
include_once '../shared/utilities.php';
include_once '../objects/cliente.php';

$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

$stmt = $cliente->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

if($num>0){
    
    $clientes_array = array();
    $clientes_array["records"] = array();
    $clientes_array["paging"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $cliente_item = array(
            "id" => $id,
            "nome" => $nome,
            "email" => $email,
            "telefone" => $telefone,
            "estado" => $estado,
            "cidade" => $cidade,
            "data_nasc" => date('d/m/Y', strtotime($data_nasc))
        );
        array_push($clientes_array["records"], $cliente_item);
    }

    $total_rows = $cliente->count();
    $page_url = "{$home_url}cliente/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $clientes_array["paging"] = $paging;
    
    http_response_code(200);
    
    echo json_encode($clientes_array);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Sem clientes para exibir."));
}
?>