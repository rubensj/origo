$(document).ready(function(){
    $(document).on('click', '.read-one-cliente-btn', function(){
    	var id = $(this).attr('data-id');
    	$.getJSON("http://testeorigo.local/api/cliente/read_one.php?id=" + id, function(data){
    		var assinaturas = data.assinaturas;
    		$.getJSON("http://testeorigo.local/api/plano/read.php", function(data_planos){
    			var planos_assinados_html=``;
	            $.each(assinaturas[0], function(key, val){
	            	planos_assinados_html+=`<tr>`;
	            	cur_plano = data_planos.records.filter(
	            			function(data){ return data.id == val.id_plano }
	            	);
	            	planos_assinados_html+=`<td>Assinatura ` + (parseInt(key)+1) + `</td>`;
	            	planos_assinados_html+=`<td>` + cur_plano[0].nome + `</td>
		            </tr>`;
	            });
	            var read_one_cliente_html=`
	    		    <div id='read-clientes' class='btn btn-primary float-right mb-3 read-clientes-btn'>
	    		        <i class="fas fa-list"></i> Ver clientes
	    		    </div>
	    		    <div class='table-responsive'>
						<table class='table table-bordered table-hover'>
						    <tr>
						        <td>Nome</td>
						        <td>` + data.nome + `</td>
						    </tr>
						    <tr>
						        <td>E-mail</td>
						        <td>` + data.email + `</td>
						    </tr>
						    <tr>
						        <td>Telefone</td>
						        <td>` + data.telefone + `</td>
						    </tr>
						    <tr>
						        <td>Estado</td>
						        <td>` + data.estado + `</td>
						    </tr>
						    <tr>
						        <td>Cidade</td>
						        <td>` + data.cidade + `</td>
						    </tr>
						    <tr>
						        <td>Data de nascimento</td>
						        <td>` + data.data_nasc + `</td>
						    </tr>
						    <tr>
						        <td colspan='2' class='text-center'>Assinaturas</td>
						    </tr>
						    ` + planos_assinados_html + `
						</table>
					</div>`;
	    		$("#page-content").html(read_one_cliente_html);
	    		changePageTitle("Detalhes do cliente");
    		});
    	});
    });
 
});