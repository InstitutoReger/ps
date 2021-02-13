$(document).ready(function(){
 

$('.deletavaga').click(function(e){

	e.preventDefault();


	var pid = $(this).attr('data-id');
	var parent = $(this).parent("td").parent(".listvg");
	var tituloPag = $(this).parent('td').parent('.listvg').find(".nomeVg").html();
	var numVg = $(this).parent('td').parent('.listvg').find(".numVg").html();
   
	bootbox.dialog({
    	message: "<span class='msgExclusao'>Você confirma a exclusão da vaga <b>"+numVg+" - "+tituloPag+"</b> ? Esta ação é irreversível!</span>",
		title: "<i class='fa fa-trash'></i> Apagar vaga!",
		buttons: {
			success: {
				label: "Cancelar",
				className: "btn-success",
				callback: function() {
					$('.bootbox').modal('hide');
				}
    		},
			danger: {
      			label: "Apagar vaga!",
				className: "btn-danger",
				callback: function() {
       
				$.ajax({
			        type: 'POST',
        			url: 'ctrl/ctrlSite.php?acao=excluivaga',
			        data: '&idvaga='+pid,
					dataType: 'json',
					success: function(result){
						if(result['statusQuery'] == 1) {
							parent.fadeOut("slow");
							$(".respostaQuery").addClass(result['classeResultado']).html("A vaga <i>" + tituloPag + "</i>" + result['resultadoQuery']);
							setTimeout(function(){$(".avisoCV").removeClass(result['classeResultado']).html("")},5000);
						} else {
							$(".avisoCV").addClass(result['classeResultado']).html(result['resultadoQuery']);
						}
					}
        
       			}) // fim ajax
      		} // fim danger
	    } // fim buttons
	}// fim bootbox.dialog
});

});


$('.deletaedital').click(function(e){
   
	e.preventDefault();
   
	var pid = $(this).attr('data-id');
	var parent = $(this).parent(".celInscrever2").parent(".listvg");
	var tituloPag = $(this).parent('.celInscrever2').parent('.listvg').find(".celNome2").html();
   
	bootbox.dialog({
    	message: "<span class='msgExclusao'>Você confirma a exclusão do edital <b>"+tituloPag+"</b> ? Esta ação é irreversível!</span>",
		title: "<i class='fa fa-trash'></i> Apagar edital!",
		buttons: {
			success: {
				label: "Cancelar",
				className: "btn-success",
				callback: function() {
					$('.bootbox').modal('hide');
				}
    		},
			danger: {
      			label: "Apagar edital!",
				className: "btn-danger",
				callback: function() {
       
				$.ajax({
			        type: 'POST',
        			url: 'ctrl/ctrlSite.php?acao=excluiedital',
			        data: '&idedital='+pid,
					dataType: 'json',
					success: function(result){
						if(result['statusQuery'] == 1) {
							parent.fadeOut("slow");
							$(".respostaQuery").addClass(result['classeResultado']).html("O edital <i>" + tituloPag + "</i>" + result['resultadoQuery']);
							setTimeout(function(){$(".avisoCV").removeClass(result['classeResultado']).html("")},5000);
						} else {
							$(".avisoCV").addClass(result['classeResultado']).html(result['resultadoQuery']);
						}
					}
        
       			}) // fim ajax
      		} // fim danger
	    } // fim buttons
	}// fim bootbox.dialog
});
});


$('.deletaarquivo').click(function(e){

	e.preventDefault();

	var pid = $(this).attr('data-id');
	var arq = $(this).attr('data-arq');
	var parent = $(this).parent(".celInscrever2").parent(".listvg");
	var tituloPag = $(this).parent('.celInscrever2').parent('.listvg').find(".celNome2").html();
   
	bootbox.dialog({
    	message: "<span class='msgExclusao'>Você confirma a exclusão do arquivo <b>"+tituloPag+"</b> ? Esta ação é irreversível!</span>",
		title: "<i class='fa fa-trash'></i> Apagar arquivo!",
		buttons: {
			success: {
				label: "Cancelar",
				className: "btn-success",
				callback: function() {
					$('.bootbox').modal('hide');
				}
    		},
			danger: {
      			label: "Apagar arquivo!",
				className: "btn-danger",
				callback: function() {
       
				$.ajax({
			        type: 'POST',
        			url: 'ctrl/ctrlSite.php?acao=excluiarquivo',
			        data: '&idarq='+pid+'&arq='+arq,
					dataType: 'json',
					success: function(result){
						if(result['statusQuery'] == 1) {
							parent.fadeOut("slow");
							$(".avisoCV").addClass(result['classeResultado']).html("O arquivo <i>" + tituloPag + "</i>" + result['resultadoQuery']);
							setTimeout(function(){$(".avisoCV").removeClass(result['classeResultado']).html("")},5000);
						} else {
							$(".avisoCV").addClass(result['classeResultado']).html(result['resultadoQuery']);
						}
					}
       			}) // fim ajax
      		} // fim danger
	    } // fim buttons
	}// fim bootbox.dialog
});
});

  
$('.deletaetapa').click(function(e){

	e.preventDefault();

	var pid = $(this).attr('data-id');
	var parent = $(this).parent(".celInscrever2").parent(".listvg");
	var tituloPag = $(this).parent('.celInscrever2').parent('.listvg').find(".celNome2").html();
   
	bootbox.dialog({
    	message: "<span class='msgExclusao'>Você confirma a exclusão da etapa <b>"+tituloPag+"</b> ? Esta ação é irreversível!</span>",
		title: "<i class='fa fa-trash'></i> Apagar etapa!",
		buttons: {
			success: {
				label: "Cancelar",
				className: "btn-success",
				callback: function() {
					$('.bootbox').modal('hide');
				}
    		},
			danger: {
      			label: "Apagar etapa!",
				className: "btn-danger",
				callback: function() {
       
				$.ajax({
			        type: 'POST',
        			url: 'ctrl/ctrlSite.php?acao=excluietapa',
			        data: '&idetapa='+pid,
					dataType: 'json',
					success: function(result){
						if(result['statusQuery'] == 1) {
							parent.fadeOut("slow");
							$(".respostaQuery").addClass(result['classeResultado']).html("A etapa <i>" + tituloPag + "</i>" + result['resultadoQuery']);
							setTimeout(function(){$(".avisoCV").removeClass(result['classeResultado']).html("")},5000);
						} else {
							$(".avisoCV").addClass(result['classeResultado']).html(result['resultadoQuery']);
						}
					}
       			}) // fim ajax
      		} // fim danger
	    } // fim buttons
	}// fim bootbox.dialog
});
});

  

$('.deletainscricao').click(function(e){
   
	e.preventDefault();
   
	var id_usuario = $(this).attr('data-id-usuario');
	var id_vaga    = $(this).attr('data-id-vaga');
	var parent     = $(this).parent("td").parent(".listaInscricoes");
	var candidato  = $(this).parent('td').parent('.listaInscricoes').find(".nomeCandidato").html();
	var cargo      = $('#cargo').html();
	var edital     = $('#edital').html();
	var numIns     = $('#numInscricoes').html();
   

	bootbox.dialog({
    	message: "<span class='msgExclusao'><b class='vc'>Esta ação é irreversível!</b><br> Antes de excluir, verifique novamente as informações do candidato(a): <br>Nome: <b>"+candidato+"</b><br>Cargo: <b>"+cargo+"</b><br>Edital: <b>"+edital+"</b></span>",
		title: "<i class='fa fa-trash'></i> Apagar inscrição!",
		buttons: {
			success: {
				label: "Cancelar",
				className: "btn-success",
				callback: function() {
					$('.bootbox').modal('hide');
				}
    		},
			danger: {
      			label: "Apagar inscrição",
				className: "btn-danger",
				callback: function() {
       
				$.ajax({
			        type: 'POST',
        			url: 'ctrl/ctrlSite.php?acao=excluiInscricao',
			        data: '&id_usuario='+id_usuario+'&id_vaga='+id_vaga,
					dataType: 'json',
					success: function(result){
						if(result['statusQuery'] == 1) {
							parent.fadeOut("slow");
							$(".avisoCV").addClass(result['classeResultado']).html("A inscrição do candidato (a) <i>" + candidato + "</i>" + result['resultadoQuery']);
							numIns = numIns-1;
							$("#numInscricoes").html(numIns);
						} else {
							$(".avisoCV").addClass(result['classeResultado']).html(result['resultadoQuery']);
						}
					}
        
       			}) // fim ajax
      		} // fim danger
	    } // fim buttons
	}// fim bootbox.dialog
});
});  

});