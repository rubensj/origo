$(document).ready(function(){
    $(document).on('click', '.update-assinatura-btn', function(){
    	var id = $(this).attr('data-id'); 
	    $.getJSON("http://testeorigo.local/api/plano/read.php", function(data_planos){
	    	var planos_options_html = `<select name='id_plano' class='form-control'>`;
    		$.each(data_planos.records, function(key, val){
    			planos_options_html+=`<option value='` + val.id + `'>` + val.nome + `</option>`;
    		});
    		planos_options_html+=`</select>`; 
            var update_assinatura_html=`
                <div id='read-clientes' class='btn btn-primary float-right mb-3 read-clientes-btn'>
                    <i class="fas fa-list"></i> Ver clientes
                </div>
				<form id='update-assinatura-form' action='#' method='post' border='0'>
					<div class='table-responsive'>
					    <table class='table table-hover table-bordered'>
					        </tr>
					        	<td>Plano</td>
					        	<td>` + planos_options_html + `</td>
					        <tr>
					            <td colspan='2' class='text-center'><input value=\"` + id + `\" name='id' type='hidden' />
					                <button type='submit' class='btn btn-info'>
					                    <i class="fas fa-save"></i> Atualizar assinatura
					                </button>
					            </td>
					        </tr>
					    </table>
					</div>
				</form>`;
            $("#page-content").html(update_assinatura_html);
            changePageTitle("Atualizar assinatura");
	    });
	});
    $(document).on('submit', '#update-assinatura-form', function(){
    	var form_data=JSON.stringify($(this).serializeObject());
    	$.ajax({
    	    url: "http://testeorigo.local/api/assinatura/update.php",
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