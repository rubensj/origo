$(document).ready(function(){
    showClientesFirstPage();
    $(document).on('click', '.read-clientes-btn', function(){
    	showClientesFirstPage();
    });
    $(document).on('click', '.pagination li', function(){
        var json_url=$(this).find('a').attr('data-page');
        showClientes(json_url);
    });
}); 
function showClientesFirstPage(){
    var json_url="http://testeorigo.local/api/cliente/read_paging.php";
    showClientes(json_url);
}
function showClientes(json_url){
    $.getJSON(json_url, function(data){
    	readClientesTemplate(data, "");
        changePageTitle("Ver clientes");
    });
}