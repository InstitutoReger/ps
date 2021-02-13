<? include('ctrl/ctrlSite.php');?>
<? include('inc_header.php');?>
<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo.png">
    </div>
</header>

<div class="container">
	<div class="row text-center">
		<div class="avisoCV vc mt20 fw6 <?=$classer?>"><?=$avisor;?></div>
        
    	<h1>Recuperar dados de acesso</h1>
        <p>Informe o email da sua conta</p>
		<form class="form-inline" method="post" name="recSenha" action="<?=$_SERVER['PHP_SELF'];?>?acao=recuperasenha">
        	<div class="form-group">
						<label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" required />
						<input type="submit" class="btn btn-default vb" value="Enviar" />

            </div>
        </form>
    </div>
</div>

</body>
</html>