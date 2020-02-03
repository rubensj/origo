<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/db.php';
include_once '../objects/plano.php';

$database = new Database();
$db = $database->getConnection();

$plano = new Plano($db);

$nome = isset($_GET["nome"]) ? $_GET["nome"] : "";
$min_mensalidade = isset($_GET["min"]) ? $_GET["min"] : "";
$max_mensalidade = isset($_GET["max"]) ? $_GET["max"] : $plano->getMaxMensalidade();

if(!empty($nome) ||
    !empty($min_mensalidade) ||
    !empty($max_mensalidade)
){

    $stmt = $plano->search($nome, $min_mensalidade, $max_mensalidade);
    $num = $stmt->rowCount();
    
    if($num>0){
        $planos_array = array();
        $planos_array["records"] = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $plano_item = array(
                "id" => $id,
                "nome" => $nome,
                "mensalidade" => $mensalidade,
            );
            array_push($planos_array["records"], $plano_item);
        }
        http_response_code(200);
        echo json_encode($planos_array);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "A busca não retornou resultados."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Não foi possível efetuar a busca. Preencha pelo menos um dado!"));
}
?>