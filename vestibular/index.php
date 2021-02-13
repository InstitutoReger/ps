<? include('../ctrl/ctrlSite.php');?>
<? include('inc_header.php');?>
<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="../img/logo.png">
        <img src="../img/itego_sed_govgoias.jpg" class="isg">
    </div>
</header>

<div class="container mt30">
	<h2 class="text-center">Processo de Seleção Para Aproveitamento de Vagas Remanescentes ITEGO ACN 2017/2</h2>
    <h3 class="text-center">Curso Superior de Tecnologia em Gestão da Produção Industrial</h3>
	<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>
	
    <br />
    <h5 id="txtExp" class="vc text-center">Faça login abaixo para realizar sua inscrição ou clique em "criar dados de acesso" caso não possua cadastro</h5>
	<div class="frmLogin">
        <form id="signin" class="navbar-form navbar-brand" role="form"  method="post" action="<?=$_SERVER['PHP_SELF']?>?acao=loginInscricao">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="cpf" type="text" class="form-control" name="cpf" value="" placeholder="CPF" onBlur="validarCPF(this);">
            </div>
    
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="senha" type="password" class="form-control" name="senha" value="" placeholder="Senha">                                        
            </div>
    
            <button type="submit" class="btn btn-primary">Entrar</button> ou <button type="submit" id="btnAddAcc" class="btn btn-danger">Criar dados de acesso</button>
        
        <div style="clear:both"></div>
        <a href="#" class="recsenhavest">Esqueci minha senha</a>
        </form>
    </div>
    <br />
    
    <div class="frmAddAcc" style="display:none">
		<form id="addAcc" class="navbar-form navbar-brand" role="form" method="post" action="<?=$_SERVER['PHP_SELF']?>?acao=addUserInscricao">
			<div class="input-group">
				<input type="email" class="form-control" placeholder="E-mail" name="addemail" required="required" />
            </div>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="CPF" name="addcpf" id="addcpf" onBlur="validarCPF(this);" required="required" />
            </div>
			<div class="input-group">
				<input type="password" class="form-control" placeholder="Senha" name="addsenha" required="required" />
            </div>
			<div class="input-group">
				<input type="submit" class="btn btn-danger" value="Criar conta" />
            </div>
        </form>
    </div>
    
    <div class="frmFgtPass" style="display:none">
		<form id="fgtPass" class="navbar-form navbar-brand" role="form" method="post" action="<?=$_SERVER['PHP_SELF']?>?acao=esqueceuSenha">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="CPF" name="novocpf" id="novocpf" onBlur="validarCPF(this);" />
            </div>
			<div class="input-group">
				<input type="submit" class="btn btn-danger" value="Recuperar senha" />
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	$('#btnAddAcc').on('click', function(e){
		e.preventDefault();
		$('.frmLogin').animate({
			top: '-=50px',
			opacity: '0'
		});
		
		$('.frmAddAcc').delay(500).show('slow');
	});
	
	$('.recsenhavest').on('click', function(e){
		e.preventDefault();
		$('.frmLogin').animate({
			top: '-=50px',
			opacity: '0'
		});
		
		$('#txtExp').html('Informe o CPF da conta que deseja recuperar a senha');
		$('.frmFgtPass').delay(500).show('slow');
	
	});
</script>
</body>
</html>