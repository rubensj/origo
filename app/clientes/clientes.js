function readClientesTemplate(data, keywords){
    var read_clientes_html=`
        <form id='search-cliente-form' action='#' method='post'>
	        <div class='input-group float-left w-25'>
	            <input type='text' value='` + keywords + `' name='keywords' class='form-control cliente-search-keywords' placeholder='Buscar cliente...' />
	            <span class='input-group-btn'>
	                <button type='submit' class='btn btn-dark' type='button'>
	                    <i class="fas fa-search"></i>
	                </button>
	            </span>
	        </div>
        </form>
        <div id='create-cliente' class='btn btn-primary float-right mb-3 create-cliente-btn'>
            <i class="fas fa-user-plus"></i> Adicionar cliente
        </div>
        <table class='table table-bordered table-hover'>
		    <tr>
		        <th scope='col' class='text-center'>Nome</th>
		        <th scope='col' class='text-center'>E-mail</th>
		        <th scope='col' class='text-center'>Telefone</th>
		        <th scope='col' class='text-center'>Estado</th>
		        <th scope='col' class='text-center'>Cidade</th>
		        <th scope='col' class='text-center'>Data de nascimento</th>
		        <th scope='col' class='text-center'>Ações</th>
		    </tr>`;
    $.each(data.records, function(key, val) {
		read_clientes_html+=`
	        <tr>
	            <td>` + val.nome + `</td>
	            <td>` + val.email + `</td>
	            <td>` + val.telefone + `</td>
	            <td>` + val.estado + `</td>
	            <td>` + val.cidade + `</td>
	            <td>` + val.data_nasc + `</td>
	            <td class='text-center'>
	                <button class='btn btn-primary read-one-cliente-btn' title='Ver' data-id='` + val.id + `'>
	                    <i class='fas fa-eye'></i>
	                </button>
	                <button class='btn btn-info update-cliente-btn' title='Editar' data-id='` + val.id + `'>
	                    <i class="fas fa-pencil-alt"></i>
	                </button>
	                <button class='btn btn-danger delete-cliente-btn' title='Apagar' data-id='` + val.id + `'>
	                    <i class="fas fa-trash-alt"></i>
	                </button>
	            </td>
	        </tr>`;
    	});
    	read_clientes_html+=`</table>`;
    	if(data.paging){
    		read_clientes_html+="<nav aria-label='Navegação'>" +
    				"<ul class='pagination float-left m-0 pb-3'>";
    	        if(data.paging.first!=""){
    	        	read_clientes_html+="<li class='page-item'><a class='page-link' data-page='" + data.paging.first + "'>Primeira</a></li>";
    	        }
    	        $.each(data.paging.pages, function(key, val){
    	            var active_page=val.current_page=="true" ? "class='active'" : "";
    	            read_clientes_html+="<li class='page-item' " + active_page + "><a class='page-link' data-page='" + val.url + "'>" + val.page + "</a></li>";
    	        });
    	        if(data.paging.last!=""){
    	        	read_clientes_html+="<li class='page-item'><a class='page-link' data-page='" + data.paging.last + "'>Última </a></li>";
    	        }
    	    read_clientes_html+="</ul></nav>";
    	}
    	$("#page-content").html(read_clientes_html);
};