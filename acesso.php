<?php include('inc_header.php');?>
<?php include('ctrl/ctrlSite.php');?>
<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo.png">
    </div>
</header>

<div class="container">
	<div class="row text-center">
		<div class="avisoCV vc mt20 fw6 <?=$classer?>"><?=$avisor;?></div>
        
        <h1>Dados de acesso</h1>
        <p>Cadastre os dados de acesso, em seguida, preencha seu currículo!</p>
		<form class="form-inline" method="post" action="<?=$_SERVER['PHP_SELF'];?>?acao=novousuario" onsubmit="return validaNovoUsuario(this);">
            <div class="form-group">
						<label>Email</label>
                        <input type="email" name="novoEmail" id="novoemail" class="form-control" />
						<label>Senha</label>
                        <input type="password" name="novaSenha" id="novaSenha" class="form-control" />
						<input type="submit" class="btn btn-default vb" value="Cadastrar" />

            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function validaNovoUsuario(form){
    if(form.novoEmail.value == ''){
        alert('Por favor, informe um email');
        form.novoEmail.focus();
        return false;
    } else {
        if(!validaEmail(form.novoEmail.value)){
            alert('Por favor, informe um e-mail válido');
            form.novoEmail.focus();
            return false;
        }
    }

    if(form.novaSenha.value == ''){
        alert('Informe uma senha');
        form.novaSenha.focus();
        return false;
    }

}

 //verifica se o email informado é válido
function validaEmail(email){
    ER = new RegExp("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]{2,64}(\.[a-z0-9-]{2,64})*\.[a-z]{2,4}$");
    if (ER.test(email)){
        return true;
    }else{
        return false;
    }
}
</script>
</body>
</html>