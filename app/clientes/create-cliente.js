$(document).ready(function(){
    $(document).on('click', '.create-cliente-btn', function(){
    	$.getJSON("http://testeorigo.local/api/plano/read.php", function(data){
    		var planos_options_html = `<select name='plano_id' class='form-control'>`;
    		$.each(data.records, function(key, val){
    			planos_options_html+=`<option value='` + val.id + `'>` + val.nome + `</option>`;
    		});
    		planos_options_html+=`</select>`;
	    	var create_cliente_html=`
	    	    <div id='read-clientes' class='btn btn-primary float-right mb-3 read-clientes-btn'>
	    	        <i class="fas fa-list"></i> Ver clientes
	    	    </div>
				<form id='create-cliente-form' action='#' method='post' border='0'>
					<div class='table-responsive'>
					    <table class='table table-hover table-bordered'>
					        <tr>
					            <td>Nome</td>
					            <td><input type='text' name='nome' class='form-control' required oninvalid="this.setCustomValidity('Campo obrigatório!')" 
onchange="try{setCustomValidity('')}catch(e){}"/></td>
					        </tr>
					        <tr>
					            <td>E-mail</td>
					            <td><input type='text' name='email' class='form-control' required oninvalid="this.setCustomValidity('Campo obrigatório!')" 
onchange="try{setCustomValidity('')}catch(e){}"/></td>
					        </tr>
					        <tr>
					            <td>Telefone</td>
					            <td><input type='tel' name='telefone' class='form-control' required oninvalid="this.setCustomValidity('Campo obrigatório!')" 
onchange="try{setCustomValidity('')}catch(e){}"/></td>
					        </tr>
					        <tr>
					            <td>Estado</td>
					            <td><select name="estado" class='form-control' required oninvalid="this.setCustomValidity('Campo obrigatório!')" 
onchange="try{setCustomValidity('')}catch(e){}">
									    <option value="" selected disabled>-- Selecione --</option>
									    <option value="Acre">Acre</option>
									    <option value="Alagoas">Alagoas</option>
									    <option value="Amapá">Amapá</option>
									    <option value="Amazonas">Amazonas</option>
									    <option value="Bahia">Bahia</option>
									    <option value="Ceará">Ceará</option>
									    <option value="Distrito Federal">Distrito Federal</option>
									    <option value="Espírito Santo">Espírito Santo</option>
									    <option value="Goiás">Goiás</option>
									    <option value="Maranhão">Maranhão</option>
									    <option value="Mato Grosso">Mato Grosso</option>
									    <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
									    <option value="Minas Gerais">Minas Gerais</option>
									    <option value="Pará">Pará</option>
									    <option value="Paraíba">Paraíba</option>
									    <option value="Paraná">Paraná</option>
									    <option value="Pernambuco">Pernambuco</option>
									    <option value="Piauí">Piauí</option>
									    <option value="Rio de Janeiro">Rio de Janeiro</option>
									    <option value="Rio Grande do Norte">Rio Grande do Norte</option>
									    <option value="Rio Grande do Sul">Rio Grande do Sul</option>
									    <option value="Rondônia">Rondônia</option>
									    <option value="Rorâima">Rorâima</option>
									    <option value="Santa Catarina">Santa Catarina</option>
									    <option value="São Paulo">São Paulo</option>
									    <option value="Sergipe">Sergipe</option>
									    <option value="Tocantins">Tocantins</option>
									</select>
								</td>
					        </tr>
					        <tr>
					            <td>Cidade</td>
					            <td><input type='text' name='cidade' class='form-control' required oninvalid="this.setCustomValidity('Campo obrigatório!')" 
onchange="try{setCustomValidity('')}catch(e){}"/></td>
					        </tr>
					        <tr>
					            <td>Data de nascimento</td>
					            <td><input type='date' name='data_nasc' class='form-control' required oninvalid="this.setCustomValidity('Campo obrigatório!')" 
onchange="try{setCustomValidity('')}catch(e){}"/></td>
					        </tr>
					        <tr>
					            <td>Plano</td>
					            <td>` + planos_options_html + `</td>
					        </tr>
					        <tr>
					            <td colspan='2' class='text-center'>
					                <button type='submit' class='btn btn-primary'>
					                    <i class="fas fa-user-plus"></i> Adicionar cliente
					                </button>
					            </td>
					        </tr>
					    </table>
					</div>
				</form>`;
    	$("#page-content").html(create_cliente_html);
    	changePageTitle("Adicionar cliente");
    	$('input[name="telefone"]').mask('(00) 90000-0000');
    	});
    });
    $(document).on('submit', '#create-cliente-form', function(){
    	var form_data = JSON.stringify($(this).serializeObject());
    	$.ajax({
    	    url: "http://testeorigo.local/api/cliente/create.php",
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