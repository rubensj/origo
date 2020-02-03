$(document).ready(function(){
    $(document).on('click', '.update-cliente-btn', function(){
    	var id = $(this).attr('data-id');
    	$.getJSON("http://testeorigo.local/api/cliente/read_one.php?id=" + id, function(data){
    	    var nome = data.nome;
    	    var email = data.email;
    	    var telefone = data.telefone;
    	    var estado = data.estado;
    	    var cidade = data.cidade;
    	    var data_nasc = data.data_nasc;
    	    var assinaturas = data.assinaturas;
    	     
    	    $.getJSON("http://testeorigo.local/api/plano/read.php", function(data_planos){
	            var planos_assinados_html=``;
	            $.each(assinaturas[0], function(key, val){
	            	planos_assinados_html+=`<tr>`;
	            	cur_plano = data_planos.records.filter(
	            			function(data){ return data.id == val.id_plano }
	            	);
	            	planos_assinados_html+=`<td>Assinatura ` + (parseInt(key)+1) + `</td>`;
	            	planos_assinados_html+=`<td>` + cur_plano[0].nome + `</td>`;
	            	planos_assinados_html+=`<td class='text-center'>
		                <button type="button" class='btn btn-info update-assinatura-btn' title='Editar' data-id='` + val.id + `'>
		                    <i class="fas fa-pencil-alt"></i>
		                </button>
		                <button type="button" class='btn btn-danger delete-assinatura-btn' title='Apagar' data-id='` + val.id + `'>
		                    <i class="fas fa-trash-alt"></i>
		                </button>
		                </td>
		            </tr>`;
	            }); 
	            var update_cliente_html=`
	                <div id='read-clientes' class='btn btn-primary float-right mb-3 read-clientes-btn'>
	                    <i class="fas fa-list"></i> Ver clientes
	                </div>
					<form id='update-cliente-form' action='#' method='post' border='0'>
						<div class='table-responsive'>
						    <table class='table table-hover table-bordered'>
						        <tr>
						            <td>Nome</td>
						            <td colspan='2'><input value=\"` + nome + `\" type='text' name='nome' class='form-control' required /></td>
						        </tr>
						        <tr>
						            <td>E-mail</td>
						            <td colspan='2'><input value=\"` + email + `\" type='text' min='1' name='email' class='form-control' required /></td>
						        </tr>
						        <tr>
						            <td>Telefone</td>
						            <td colspan='2'><input value=\"` + telefone + `\" type='tel' name='telefone' class='form-control' required /></td>
						        </tr>
						        <tr>
						            <td>Estado</td>
						            <td colspan='2'><input value=\"` + estado + `\" type='text' name='estado' class='form-control' required /></td>
						        </tr>
						        <tr>
						            <td>Cidade</td>
						            <td colspan='2'><input value=\"` + cidade + `\" type='text' name='cidade' class='form-control' required /></td>
						        </tr>
						        <tr>
						            <td>Data de nascimento</td>
						            <td colspan='2'><input value=\"` + data_nasc + `\" type='date' name='data_nasc' class='form-control' required /></td>
						        </tr>
						        <tr>
						            <td colspan="3" class="text-center">Assinaturas
						            <button type="button" class='btn btn-primary create-assinatura-btn float-right' title='Adicionar' data-id='` + id + `'>
					                    <i class="fas fa-plus"></i> Adicionar assinatura
					                </button>
						            </td>
						        </tr>
						        ` + planos_assinados_html + `
						        <tr>
						            <td colspan='3' class='text-center'><input value=\"` + id + `\" name='id' type='hidden' />
						                <button type='submit' class='btn btn-info'>
						                    <i class="fas fa-save"></i> Atualizar cliente
						                </button>
						            </td>
						        </tr>
						    </table>
						</div>
					</form>`;
	            $("#page-content").html(update_cliente_html);
	            changePageTitle("Atualizar cliente");
	            $('input[name="telefone"]').mask('(00) 90000-0000');
    	    });
    	});
    });
    $(document).on('submit', '#update-cliente-form', function(){
    	var form_data=JSON.stringify($(this).serializeObject());
    	$.ajax({
    	    url: "http://testeorigo.local/api/cliente/update.php",
    	    type : "POST",
    	    contentType : 'application/json',
    	    data : form_data,
    	    success : function(result) {
    	    	showClientesFirstPage();
    	    },
    	    error: function(xhr, resp, text) {
    	        console.log(xhr, resp, text);
    	        var err = $.parseJSON(xhr.responseText);
	            bootbox.alert("Erro: " + JSON.stringify(err.message));
    	    }
    	});
        return false;
    });
});