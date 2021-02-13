$(document).ready(function() {
	$('#rootwizard2').bootstrapWizard();
  	$('#rootwizard').bootstrapWizard({onNext: function(tab, navigation, index) {

			if(index==1) {

				if(!$('#nome').val()){
					alert('Informe seu nome');
					$('#nome').focus();
					return false;
				}

				if(!$('#email').val()){
					alert('Informe seu email');
					$('#email').focus();
					return false;
				}

				if(!$('#genero').val()){
					alert('Informe seu gênero');
					$('#genero').focus();
					return false;
				}

				if(!$('#estadocivil').val()){
					alert('Informe seu estado civil');
					$('#estadocivil').focus();
					return false;
				}

				if(!$('#nascimento').val()){
					alert('Informe sua data de nascimento');
					$('#nascimento').focus();
					return false;
				}

				if(!$('#pcd').val()){
					alert('Informe se você possui alguma deficiência');
					$('#pcd').focus();
					return false;
				}


				if($("#pcd").val() == 'Sim') {
					if(!$('#deficiencia').val()){
						alert('Informe o tipo da deficiência');
						$('#deficiencia').focus();
						return false;
					}
					if(!$('#cid').val()){
						alert('Informe o CID');
						$('#cid').focus();
						return false;
					}
				}

				if(!$('#filhos').val()){
					alert('Informe se você tem filhos');
					$('#filhos').focus();
					return false;
				}


				if($("#filhos").val() == 'Sim') {
					if(!$('#qtyfilhos').val()){
						alert('Informe quantos filhos você tem');
						$('#qtyfilhos').focus();
						return false;
					}
				}

				if(!$('#cep').val()){
					alert('Informe seu CEP');
					$('#cep').focus();
					return false;
				}

				if(!$('#rua').val()){
					alert('Informe o nome da rua');
					$('#rua').focus();
					return false;
				}

				if(!$('#numero').val()){
					alert('Informe o número da sua residência. Se não houver, coloque 0');
					$('#numero').focus();
					return false;
				}

				if(!$('#complemento').val()){
					alert('Informe o complemento do seu endereço');
					$('#complemento').focus();
					return false;
				}

				if(!$('#bairro').val()){
					alert('Informe seu bairro');
					$('#bairro').focus();
					return false;
				}

				if(!$('#cidade').val()){
					alert('Informe sua cidade');
					$('#cidade').focus();
					return false;
				}
				
				if(!$('#uf').val()){
					alert('Informe seu estado');
					$('#uf').focus();
					return false;
				}				

				if(!$("#tel_res").val() && !$("#tel_cel").val() && !$("#tel_com").val()) {
					alert("Informe pelo menos um telefone para contato");
					$("#tel_res").focus();
					return false;
				}

				if(!$('#naturalidade').val()){
					alert('Informe sua naturalidade');
					$('#naturalidade').focus();
					return false;
				}

				if(!$('#nacionalidade').val()){
					alert('Informe sua nacionalidade');
					$('#nacionalidade').focus();
					return false;
				}

				if(!$('#mae').val()){
					alert('Informe o nome de sua mãe');
					$('#mae').focus();
					return false;
				}

			}


			if(index==2) {

				if(!$('#rg').val()){
					alert('Informe seu RG');
					$('#rg').focus();
					return false;
				}
				
				if(!$('#emissor').val()){
					alert('Informe o emissor do seu RG');
					$('#emissor').focus();
					return false;
				}

				if(!$('#ufrg').val()){
					alert('Informe o estado onde seu RG foi emitido');
					$('#ufrg').focus();
					return false;
				}

				if(!$('#cpf').val()){
					alert('Informe seu CPF');
					//$('#cpf').focus();
					return false;
				}

				if(!$('#ctps').val()){
					alert('Informe o número de sua carteira de trabalho');
					$('#ctps').focus();
					return false;
				}

				if(!$('#serie').val()){
					alert('Informe a série de sua carteira de trabalho');
					$('#serie').focus();
					return false;
				}

				if(!$('#pispasep').val()){
					alert('Informe o número do seu PIS/PASEP');
					$('#pispasep').focus();
					return false;
				}

				if(!$('#conta').val()){
					alert('Informe se você possui conta corrente na CEF');
					$('#conta').focus();
					return false;
				}

			}

			if(index==3){
				if($('#status1').val() == 'Concluído'){
					if($('#conclusao1').val().length <=5 || $('#conclusao1').val() == ''){
						alert('Informe mês e ano de conclusão. Formato: 00/0000');
						$('#conclusao1').focus();
						return false;
					}
				}
				if($('#status2').val() == 'Concluído'){
					if($('#conclusao2').val().length <=5 || $('#conclusao2').val() == ''){
						alert('Informe mês e ano de conclusão. Formato: 00/0000');
						$('#conclusao2').focus();
						return false;
					}
				}
			}

			if(index == 4){

				if(!$('#fds').val()){
					alert('Informe se você tem disponibilidade para trabalhar aos finais de semana ou feriados');
					$('#fds').focus();
					return false;
				}

				if(!$('#viagens').val()){
					alert('Informe se você tem disponibilidade para viagens');
					$('#viagens').focus();
					return false;
				}

				if(!$('#veiculo').val()){
					alert('Informe se você tem veículo próprio');
					$('#veiculo').focus();
					return false;
				}

				if(!$('#trabalha_estado').val()){
					alert('Informe se você trabalha no Estado');
					$('#trabalha_estado').focus();
					return false;
				}

				if($('#trabalha_estado').val() == 'Sim'){
					if(!$('#orgaotrabalha').val()){
						alert('Informe em qual órgão do Estado você trabalha');
						$('#orgaotrabalha').focus();
						return false;
					}
				}

				if(!$('#trabalhou_estado').val()){
					alert('Informe se você trabalhou no Estado');
					$('#trabalhou_estado').focus();
					return false;
				}

				if($('#trabalhou_estado').val() == 'Sim'){
					if(!$('#orgaotrabalhou').val()){
						alert('Informe em qual órgão do Estado você trabalhou');
						$('#orgaotrabalhou').focus();
						return false;
					}
				}

				if(!$('#parentes').val()){
					alert('Informe se você possui parentes ou afins no Instituto');
					$('#parentes').focus();
					return false;
				}

				if($('#parentes').val() == 'Sim'){
					if(!$('#atuacao').val()){
						alert('Informe a área de atuação de seu parente');
						$('#atuacao').focus();
						return false;
					}

					if(!$('#nomeparente').val()){
						alert('Informe o nome de seu parente');
						$('#nomeparente').focus();
						return false;
					}

					if(!$('#grau').val()){
						alert('Informe o grau de parentesco');
						$('#grau').focus();
						return false;
					}
				}
			}

			if(index == 7){
				if(!$('#comosoube').val()){
					alert('Informe como você soube da vaga');
					$('#comosoube').focus();
					return false;
				}
			}


		}, onTabShow: function(tab, navigation, index) {

			var $total = navigation.find('li').length;
			var $current = index+1;
		}});
});



function validaCampo(campo, mensagem){
	if(campo == 'cpf'){
	if(!$('#'+campo).val()){
		alert(mensagem);
		return false;
	}

	}
	if(!$('#'+campo).val()){
		alert(mensagem);
		$('#'+campo).focus();
		return false;
	}
}



function validafrmCv(form){

	if(form.nome.value == ''){
		alert("Informe seu nome");
		return false;
	}

	if(form.email.value == ''){
		alert("Informe seu email");
		form.email.focus();
		return false;
	}

	if(form.genero.value == ''){
		alert("Informe seu gênero");
		return false;
	}

	if(form.estadocivil.value == ''){
		alert("Informe seu estado civil");
		return false;
	}

	if(form.nascimento.value == ''){
		alert("Informe sua data de nascimento");
		return false;
	}

	if(form.pcd.value == ''){
		alert("Informe se você possui alguma deficiência");
		return false;
	}

	if(form.pcd.value == 'Sim'){
		if(form.deficiencia.value == ''){
			alert("Informe o tipo da deficiência");
			return false;
		}
	}

	if(form.filhos.value == ''){
		alert('Informe se você tem filhos');
		return false;
	}

	if(form.filhos.value == 'Sim'){
		if(form.qtyfilhos.value == ''){
			alert("Informe quantos filhos você tem");
			return false;
		}
	}

	if(form.cep.value == ''){
		alert('Informe seu CEP');
		return false;
	}

	if(form.rua.value==''){
		alert('Informe sua rua');
		return false;
	}

	if(form.numero.value==''){
		alert('Informe o número');
		return false;
	}

	if(form.complemento.value==''){
		alert('Informe o complemento do seu endereço');
		return false;
	}

	if(form.bairro.value==''){
		alert('Informe seu bairro');
		return false;
	}

	if(form.cidade.value==''){
		alert('Informe sua cidade');
		return false;
	}

	if(form.uf.value==''){
		alert('Informe seu estado');
		return false;
	}



	if(form.tel_res.value=='' && form.tel_cel.value=='' && form.tel_com.value==''){
		alert("Informe pelo menos um telefone para contato");
		return false;
	}

	
	if(form.naturalidade.value==''){
		alert('Informe sua naturalidade');
		return false;
	}

	if(form.nacionalidade.value==''){
		alert('Informe sua nacionalidade');
		return false;
	}

	if(form.mae.value==''){
		alert('Informe o nome de sua mãe');
		return false;
	}

	
	if(form.rg.value==''){
		alert('Informe seu RG');
		return false;
	}

	if(form.emissor.value==''){
		alert('Informe o emissor de seu RG');
		return false;
	}

	if(form.ufrg.value==''){
		alert('Informe o estado onde seu RG foi emitido');
		return false;
	}

	if(form.cpf.value==''){
		alert('Informe seu CPF, na Aba "Documentos complementares"');
		return false;
	}

	if(form.ctps.value==''){
		alert('Informe o número de sua carteira de trabalho');
		return false;
	}

	if(form.serie.value==''){
		alert('Informe a série de sua carteira de trabalho');
		return false;
	}

	if(form.pispasep.value==''){
		alert('Informe o número do seu PIS/PASEP');
		return false;
	}

	if(form.conta.value==''){
		alert('Informe se você possui conta corrente na CEF');
		return false;
	}

	if(form.fds.value==''){
		alert('Informe se você tem disponibilidade para trabalhar aos finais de semana ou feriados');
		return false;
	}

	if(form.viagens.value==''){
		alert('Informe se você tem disponibilidade para viagens');
		return false;
	}

	if(form.veiculo.value==''){
		alert('Informe se você tem veículo próprio');
		return false;
	}

	if(form.trabalha_estado.value==''){
		alert('Informe se você trabalha no Estado');
		return false;
	}

	if(form.trabalha_estado.value == 'Sim'){
		if(form.orgaotrabalha.value == ''){
			alert("Informe em qual órgão do Estado você trabalha");
			return false;
		}
	}

	if(form.trabalhou_estado.value==''){
		alert('Informe se você trabalhou no Estado');
		return false;
	}

	if(form.trabalhou_estado.value == 'Sim'){
		if(form.orgaotrabalhou.value == ''){
			alert("Informe em qual órgão do Estado você trabalhou");
			return false;
		}
	}

	if(form.parentes.value==''){
		alert('Informe se você possui parentes ou afins no Instituto');
		return false;
	}

	if(form.parentes.value == 'Sim'){
		if(form.atuacao.value == ''){
			alert("Informe a área de atuação de seu parente");
			return false;
		}

		if(form.nomeparente.value == ''){
			alert("Informe o nome de seu parente");
			return false;
		}

		if(form.grau.value == ''){
			alert("Informe o grau de parentesco");
			return false;
		}
	}

	if(form.comosoube.value==''){
		alert('Informe como você soube da vaga');
		return false;
	}
}

function _cpf(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function validarCPF(el){
  if( !_cpf(el.value) ){

    alert("CPF inválido!");

    // apaga o valor
    el.value = "";
  }
}