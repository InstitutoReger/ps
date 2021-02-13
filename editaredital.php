<?
$acaolocal = 'editaEdital';
include('ctrl/ctrlSite.php');
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
		<h1 class="text-center">Alterar edital</h1>
		<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>
		
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'];?>?acao=atualizaedital" method="post" name="frmcadEdital" id="frmcadEdital">
            <div class="form-group">
				<div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="<?=$e['nome'];?>" required />
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Número</label>
                        <input type="text" class="form-control" name="numero" id="numero" value="<?=$e['numero'];?>" required />
                    </div>

                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Vigente" <? if($e['status'] == 'Vigente') echo "selected";?>>Vigente</option>
                            <option value="Processo em andamento" <? if($e['status'] == 'Processo em andamento') echo "selected";?>>Processo em andamento</option>
                            <option value="Processo finalizado" <? if($e['status'] == 'Processo finalizado') echo "selected";?>>Processo finalizado</option>                    
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Início</label>
                        <input type="text" class="form-control" name="inicio"  id="inicioEdital" value="<?=formataData($e['inicio'],'php');?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Término</label>
                        <input type="text" class="form-control" name="termino" id="terminoEdital" value="<?=formataData($e['termino'],'php');?>" required>
                    </div>
                </div>
            </div>

        	<div class="form-group">
				<a href="https://institutoreger.com.br/pdf/<?=$e['edital'];?>" target="_blank">Arquivo atual</a><br />
            	<label>Edital</label>
                <input type="file" class="form-control" accept="application/pdf" name="edital" id="edital" />
            </div>
            
            
            <div class="form-group">
            <input type="hidden" name="idEdital" value="<?=$e['id'];?>" />
            <input type="hidden" name="pdf" value="<?=$e['edital'];?>" />
			<input type="submit" name="submitCadVaga" class="btn btn-default vb" value="Alterar edital" />
            </div>
        </form>

    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>