<form method="post" name="frmInscVest" id="frmInscVest" action="<?=$_SERVER['PHP_SELF'];?>?acao=cadInscVest" enctype="multipart/form-data" onsubmit="return validaInscVest(this);">
	
    <div class="row form-group">
    	<div class="col-md-6">
			<label>1ª Opção de turno do curso</label>
            <select name="turnocurso1" class="form-control">
				<option value="">Selecione</option>
                <option value="Matutino">Matutino</option>
                <option value="Noturno">Noturno</option>
            </select>
        </div>
        
    	<div class="col-md-6">
			<label>2ª opção de turno do curso</label>
            <select name="turnocurso2" class="form-control">
				<option value="">Selecione</option>
                <option value="Matutino">Matutino</option>
                <option value="Noturno">Noturno</option>
            </select>
        </div>
    </div>
    
    <div class="form-group">
		<label>Nome</label>
        <input type="text" name="nome" class="form-control" />
    </div>
    
    <div class="row form-group">
		<div class="col-md-3">
			<label>CPF</label>
            <input type="text" name="cpf" id="cpf" class="form-control" value="<?=$_SESSION['rgrv']['cpfUsuario']?>" readonly="readonly" />
        </div>
        
        <div class="col-md-3">
        	<label>RG</label>
            <input type="text" name="rg" id="rg" class="form-control" />
        </div>
        
        <div class="col-md-3">
        	<label>Orgão emissor/UF</label>
            <input type="text" name="emissor" class="form-control"  />
        </div>
        
        <div class="col-md-3">
        	<label>Data da emissão</label>
            <input type="text" name="dataemissao" id="dataemissao" class="form-control"  />
        </div>
    </div>
    
	<div class="form-group">
		<label>Nome do pai</label>
        <input type="text" name="pai" class="form-control" />
    </div>
    
	<div class="form-group">
		<label>Nome da mãe</label>
        <input type="text" name="mae" class="form-control" />
    </div>
    
    <div class="row form-group">
		<div class="col-md-6">
			<label>Nacionalidade</label>
            <input type="text" name="nacionalidade" class="form-control" />
        </div>	
        
		<div class="col-md-6">
			<label>Naturalidade/UF</label>
            <input type="text" name="naturalidade" class="form-control" />
        </div>
    </div>
    
    <div class="row form-group">
		<div class="col-md-4">
        	<label>Data de nascimento</label>
            <input type="text" name="nascimento" id="nascimento" class="form-control" />
		</div>
        
		<div class="col-md-4">
        	<label>Sexo</label>
            <select name="sexo" class="form-control">
				<option value="">Selecione</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
            </select>
		</div>
        
		<div class="col-md-4">
        	<label>Estado civil</label>
            <input type="text" name="estadocivil" class="form-control" />
		</div>
	</div>
    
    <div class="row form-group">
		<div class="col-md-6">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control" maxlength="70" value="<?=$_SESSION['rgrv']['emailUsuario']?>" readonly="readonly" />
        </div>
		<div class="col-md-6">
            <label>Como soube do vestibular?</label>
            <input type="text" name="comosoube" class="form-control" maxlength="255" />
        </div>
    </div>
    
    <div class="row form-group">
		<div class="col-md-6">
			<label>Celular</label>
            <input type="text" name="celular" id="celular" class="form-control" />
        </div>	
        
		<div class="col-md-6">
			<label>Whatsapp</label>
            <input type="text" name="whatsapp" id="whatsapp" class="form-control" />
        </div>
    </div>
    
    <div class="row form-group">
		<div class="col-md-6">
			<label>Telefone comercial</label>
            <input type="text" name="telcom" id="telcom" class="form-control" />
        </div>	
        
		<div class="col-md-6">
			<label>Telefone residencial</label>
            <input type="text" name="telres" id="telres" class="form-control" />
        </div>
    </div>
    
    <div class="row form-group">
		<div class="col-md-6">
			<label>Ano de conclusão do ensino médio</label>
            <input type="text" name="anoconclusao" class="form-control" maxlength="4" />
        </div>
		<div class="col-md-6">
            <label>Instituição de ensino</label>
            <input type="text" name="instituicao" class="form-control" />
        </div>	
    </div>
    
    <div class="row form-group">
		<div class="col-md-6">
			<label>Cidade da Instituição de ensino/UF</label>
            <input type="text" name="cidadeinstituicao" class="form-control" />
        </div>	
        
		<div class="col-md-6">
			<label>Ano que realizou a prova do ENEM</label>
            <input type="text" name="enem" class="form-control" maxlength="4" />
        </div>
    </div>
    
    <div class="form-group">
    	<label>Boletim de notas do ENEM</label>
		<input type="file" name="boletim" class="form-control" accept="application/pdf" />
    </div>
    
    <div class="form-group">
		<input type="submit" class="btn btn-default btn-lg vb" value="Enviar inscrição" />
    </div>
</form>

<script type="text/javascript">
	function validaInscVest(form){
		if(form.turnocurso1.value==''){
			alert('Informe a primeira opção de turno do curso');
			form.turnocurso1.focus();
			return false;
		}
		if(form.turnocurso2.value==''){
			alert('Informe a segunda opção de turno do curso');
			form.turnocurso2.focus();
			return false;
		}else {
			if(form.turnocurso1.value == form.turnocurso2.value){
			alert('As opções de turnos não podem ser iguais');
			form.turnocurso2.focus();
			return false;
			}
		}
		
		if(form.nome.value==''){
			alert('Informe seu nome');
			form.nome.focus();
			return false;
		}
		
		if(form.cpf.value==''){
			alert('Informe seu CPF');
			form.cpf.focus();
			return false;
		}
		
		if(form.rg.value==''){
			alert('Informe seu RG');
			form.rg.focus();
			return false;
		}
		
		if(form.emissor.value==''){
			alert('Informe o emissor do seu RG');
			form.emissor.focus();
			return false;
		}
		
		if(form.dataemissao.value==''){
			alert('Informe a data da emissão do RG');
			form.dataemissao.focus();
			return false;
		} else {
			if(form.dataemissao.value.length<10){
				alert('Preencha no formato correto: dd/mm/aaaa');
				form.dataemissao.focus();
				return false;
			}
		}

		if(form.pai.value==''){
			alert('Informe o nome do seu pai');
			form.pai.focus();
			return false;
		}
		
		if(form.mae.value==''){
			alert('Informe o nome da sua mãe');
			form.mae.focus();
			return false;
		}
		
		if(form.nacionalidade.value==''){
			alert('Informe sua nacionalidade');
			form.nacionalidade.focus();
			return false;
		}
		
		if(form.naturalidade.value==''){
			alert('Informe sua naturalidade');
			form.naturalidade.focus();
			return false;
		}
		
		if(form.nascimento.value==''){
			alert('Informe sua data de nascimento');
			form.nascimento.focus();
			return false;
		} else {
			if(form.nascimento.value.length<10){
				alert('Preencha no formato correto: dd/mm/aaaa');
				form.nascimento.focus();
				return false;
			}
		}
		
		if(form.sexo.value==''){
			alert('Selecione seu sexo');
			form.sexo.focus();
			return false;
		}
		
		if(form.estadocivil.value==''){
			alert('Informe seu estado civil');
			form.estadocivil.focus();
			return false;
		}
		
		if(form.email.value==''){
			alert('Informe seu email');
			form.email.focus();
			return false;
		}
		
		if(form.celular.value==''){
			alert('Informe seu celular');
			form.celular.focus();
			return false;
		} else {
			if(form.celular.value.length<15){
				alert('Preencha no formato correto, com DDD: (00) 99999-9999');
				form.celular.focus();
				return false;
			}
		}
		
		if(form.anoconclusao.value==''){
			alert('Informe o ano de conclusão do ensino médio');
			form.anoconclusao.focus();
			return false;
		}
		
		if(form.instituicao.value==''){
			alert('Informe a instituição de ensino');
			form.instituicao.focus();
			return false;
		}
		
		if(form.cidadeinstituicao.value==''){
			alert('Informe a cidade da Instituição de ensino');
			form.cidadeinstituicao.focus();
			return false;
		}
		
		if(form.enem.value==''){
			alert('Informe o ano que realizou o ENEM');
			form.enem.focus();
			return false;
		}
		
		if(form.boletim.value==''){
			alert('Selecione o arquivo com boletim do ENEM');
			return false;
		}
	}
</script>