$(document).ready(function(){
    $(document).on('click', '.delete-assinatura-btn', function(){
    	var id_assinatura = $(this).attr('data-id');
    	bootbox.confirm({
    	    message: "<h4>Você tem certeza que quer apagar a assinatura?</h4>",
    	    buttons: {
    	        confirm: {
    	            label: '<i class="fas fa-check"></i> Sim',
    	            className: 'btn-danger'
    	        },
    	        cancel: {
    	            label: '<i class="fas fa-times"></i> Não',
    	            className: 'btn-primary'
    	        }
    	    },
    	    callback: function (result) {
    	    	if(result==true){
    	    	    $.ajax({
    	    	        url: "http://testeorigo.local/api/assinatura/delete.php",
    	    	        type : "POST",
    	    	        dataType : 'json',
    	    	        data : JSON.stringify({ id: id_assinatura }),
    	    	        success : function(result) {
    	    	        	showClientesFirstPage();
    	    	        },
    	    	        error: function(xhr, resp, text) {
    	    	            console.log(xhr, resp, text);
    	    	            var err = $.parseJSON(xhr.responseText);
    	    	            bootbox.alert("Erro: " + JSON.stringify(err.message));
    	    	        }
    	    	    });
    	    	}
    	    }
    	});
    });
});