<? include('ctrl/ctrlSite.php');
verificaLogado();
include('inc_header.php');?>

<div class="container-fluid barraUsuario cb">
	<div class="container">
		<span class="fl">Olá, <?=$_SESSION['rgr']['emailUsuario'];?></span>
        <span class="fr"><a href="<?=$_SERVER['PHP_SELF']?>?acao=deslogar">Deslogar</a></span>
    </div>
</div>



<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo.png">
    </div>
</header>

<? include('inc_menu.php');?>
<? if(verificaNivelUser()){?>
<div class="container">
	<div class="row text-center">
		<h1 class="text-center">Cadastrar edital</h1>
		<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>
		
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'];?>?acao=cadEdital" method="post" name="frmcadEdital" id="frmcadEdital">
            <div class="form-group">
				<div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" required />
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Número</label>
                        <input type="text" class="form-control" name="numero" id="numero" required />
                    </div>

                </div>
            </div>
            
        	<div class="form-group">
				<label>Edital</label>
                <input type="file" class="form-control" accept="application/pdf" name="edital" id="edital" required />
            </div>
            
            <div class="row">
	            <div class="col-md-4">
		            <div class="form-group">
		                <label>Status</label>
		                <select name="status" class="form-control">
		                    <option value="Vigente">Vigente</option>
		                    <option value="Processo em andamento">Processo em andamento</option>
		                    <option value="Processo finalizado">Processo finalizado</option>
		                </select>
		            </div>
	            </div>

	            <div class="col-md-4">
	            	<div class="form-group">
	            		<label>Início</label>
	            		<input type="text" class="form-control" name="inicio" id="inicioEdital" required>
	            	</div>
	            </div>

	            <div class="col-md-4">
	            	<div class="form-group">
	            		<label>Término</label>
	            		<input type="text" class="form-control" name="termino" id="terminoEdital" required>
	            	</div>
	            </div>
        	</div>

            <div class="form-group">
			<input type="submit" name="submitcadEdital" class="btn btn-default vb" value="Cadastrar edital" />
            </div>
        </form>

    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>