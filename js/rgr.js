$(document).ready(function(){
	var data = $("#loginPainel").serialize();

	$('#loginPainel').submit(function(){ 	//Ao submeter formulário

		var user=$('#user').val();	//Pega valor do campo email
		var senha=$('#userpwd').val();	//Pega valor do campo senha


		$.ajax({
			url:"ctrl/ctrlSite.php?acao=login",			//Arquivo php
			type:"post",								//Método de envio
			data: "&usuario="+user+"&senha="+senha,		//Dados
   			success: function (result){					//Sucesso no AJAX

						if(result==1){
							$(".modal-dialog").empty();
							$(".modal-dialog").append('<div class="loginSuccess fr" style="opacity:0"><img src="img/loginok.png" class="imgok" /><br>Login efetuado com sucesso!</div>');
							$(".loginSuccess").animate({opacity:1},"slow");
							setTimeout(function(){location.href='listaedital.php'}, 3000);
                		}
						if(result == 2){
							$(".modal-dialog").empty();
							$(".modal-dialog").append('<div class="loginSuccess fr" style="opacity:0"><img src="img/loginok.png" class="imgok" /><br>Login efetuado com sucesso!</div>');
							$(".loginSuccess").animate({opacity:1},"slow");
							setTimeout(function(){location.href='edtcv.php'}, 3000);
						}
						if(result == 0){
							$('#msgerro').html('Usuário ou senha incorretos!');
                			$('#msgerro').css('background-color','#f7bdbd');
							setTimeout(function(){$('#msgerro').html('').css('background-color','#fff');}, 5000);
                		}
            		}
		})

		return false;	//Evita que a página seja atualizada

	})



$(".btnCadastrar").on('click', function(e){
	e.preventDefault();
	var btn = $(this);
	btn.html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Aguarde...');

	var idPS   = btn.attr('data-id-proc');
	var idUser = btn.attr('data-id-user');
	var idEdt  = btn.attr('data-id-edital');

	$.ajax({
		url:'ctrl/ctrlSite.php?acao=vinculaUV',
		type:'POST',
		dataType:'json',
		data:'&usuario='+idUser+'&ps='+idPS+'&edital='+idEdt,
		success: function(codResult){
			if(codResult == 0){
				btn.html('<span class="glyphicon glyphicon-ok"></span> Inscrição realizada').removeClass('vb').addClass('btn-success disabled');
				btn.removeClass('btnInscr');
			}
			if(codResult == 1){
				$("#avisoInsc").show().html('Você já está inscrito(a) em outra vaga.');
				btn.html('Candidatar');
			}
			if(codResult == 2){
				$("#avisoInsc").show().html('O período de inscrições desta vaga não está ativo. Verifique no edital.');
				btn.html('Candidatar');
			}
			if(codResult == 3){
				$("#avisoInsc").show().html('Seu currículo não está preenchido. Preencha seu currículo e tente novamente.');
				btn.html('Candidatar');
			}
		}
	});
});

})



function validalogin(form){
	if(form.user.value == ""){
		$('#msgerro').html('Informe seu e-mail');
		$('#msgerro').css('background-color','#f7bdbd');
		form.user.focus();
		setTimeout(function(){$('#msgerro').html('').css('background-color','#fff');}, 3000);
		return false;
	}else {
		if(!validaEmail(form.user.value)){
		$('#msgerro').html('Insira um e-mail válido');
		$('#msgerro').css('background-color','#f7bdbd');
		form.user.focus();
		setTimeout(function(){$('#msgerro').html('').css('background-color','#fff');}, 3000);
		return false;
		}
	}

	if(form.userpwd.value == ""){
		$('#msgerro').html('Informe sua senha');
		$('#msgerro').css('background-color','#f7bdbd');
		form.userpwd.focus();
		setTimeout(function(){$('#msgerro').html('').css('background-color','#fff');}, 3000);
		return false;
	}
	return true;
}



function validaEmail(email){
	ER = new RegExp("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]{2,64}(\.[a-z0-9-]{2,64})*\.[a-z]{2,4}$");
	if (ER.test(email)){
		return true;
	}else{
		return false;
	}
}

function validaNovaSenha(form){
	console.log(form.senha.value);
	if(form.senha.value.length < 6 || form.senha2.value.length < 6){
		alert("Informe uma senha com no mínimo 6 (seis) caracteres");
		return false;
	}
	if(form.senha.value != form.senha2.value){
		alert("As senhas digitadas não são iguais, por favor, verifique se digitou corretamente");
		return false;
	}
}

function validaFrmRecurso(form){
	if(form.edital.value == ''){
		alert("Selecione o edital");
		return false;
	}
	
	if(form.cargo.value == ''){
		alert("Informe o cargo");
		form.cargo.focus();
		return false;
	}

	if(form.vaga.value == ''){
		alert("Informe a vaga");
		form.vaga.focus();
		return false;
	}
	
	if(form.email.value == ''){
		alert("Informe o email");
		return false;
	}
	
	if(form.etapa.value == ''){
		alert("Selecione a etapa");
		return false;
	}
	
	if(form.nome.value == ''){
		alert("Informe o nome");
		form.nome.focus();
		return false;
	}
	
	if(form.justificativa.value == ''){
		alert("Digite sua justificativa");
		return false;
	}
}


//busca recursos por edital
$(document).ready(function(){
	$('.listaRecursosEdital').on('click', function(e){
		e.preventDefault();
		var idEdital = $(this).attr('data-edital');
		var etapa    = $(this).attr('data-etapa');
		var nEdital  = $(this).closest('tr').children('td.nomeEdital').html();

		//desce a rolagem até a div que exibirá os recursos
		$('html,body').animate({
			scrollTop: $('.listagemRecursos').offset().top
		},2000);

		//exibe o ícone de loading
		$('.listagemRecursos').html('<img src="http://institutoreger.org.br/processoseletivo/img/ajax-loader.gif" /> Buscando recursos ...').addClass('text-center');

		//deixa o ícone de loading visível por 1 segundo e depois faz a requisição dos recursos do edital
		setTimeout(function(){
			$.ajax({
				url: 'ctrl/ctrlSite.php?acao=buscaRecursos',
				data: 'idEdital='+idEdital+'&etapa='+etapa,
				type: 'POST',
				success: function(data){
					$('.listagemRecursos').html('').append('<h1 class="text-center">Recursos do edital '+nEdital+'</h1>');
					$('.listagemRecursos').removeClass('text-center').append(data);
				}
			})
		},1000)
	});	
})
