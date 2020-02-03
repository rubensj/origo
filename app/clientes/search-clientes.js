$(document).ready(function(){
    $(document).on('submit', '#search-cliente-form', function(){
        var keywords = $(this).find(":input[name='keywords']").val();
        $.getJSON("http://testeorigo.local/api/cliente/search.php?q=" + keywords, function(data){
            readClientesTemplate(data, keywords);
            changePageTitle("Busca em clientes: " + keywords);
        });
        return false;
    });
});