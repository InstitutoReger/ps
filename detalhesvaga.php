<? $acaolocal = 'detalhesVaga';?>
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

<div class="container">
	<div class="row infoVaga">
		<h4><b>Cargo: </b><?=$vaga['cargo'];?></h4>
		<h4><b>Número da vaga:</b> <?=$vaga['numero'];?></h4>
		<h4><b>Nome do edital:</b> <?=nomeEdital($vaga['edital']);?></h4>
		<h4><b>Local:</b> <?=$vaga['local'];?></h4>
		<h4><b>Atribuições:</b> <?=$vaga['atribuicoes'];?></h4>
		<h4><b>Formação ou requisitos:</b> <?=$vaga['formacao'];?></h4>
		<h4><b>Quantidade de vagas:</b> <?=$vaga['vagas'];?></h4>
		<h4><b>Carga horária:</b> <?=$vaga['carga'];?></h4>
		<h4><b>Turno:</b> <?=$vaga['turno'];?></h4>
		<h4><b>Salário:</b> <?=$vaga['salario'];?></h4>
		<!--<h4><b>Período de inscrição:</b> <?=formataData($vaga['inicio'], 'php');?> à <?=formataData($vaga['termino'], 'php');?></h4>-->
		<h4><b>Edital:</b> <b><?=buscaEdital($vaga['edital']);?></h4>
		<br />
        
        <?php if($qtyCv == 0){
        	$msgError = 'Verifique se as informações do seu currículo estão preenchidas corretamente.';
        }?>
        
        <div class="alert alert-warning" id="avisoInsc" role="alert" <?php if($qtyCv > 0){ echo "style='display:none'";}?>>
        	<?php echo $msgError;?>
        </div>

		<? if(verificaInscricao($vaga['id'])) {?>
				<a href="#" class="btnCadastrar btn btn-default disabled btn-success"><span class="glyphicon glyphicon-ok"></span> Inscrição realizada</a>
		<? } else {?>
        		<? if($vaga['status'] == 'Vigente'){?>
	              	<a href="#" 
	              	data-id-proc="<?=$vaga['id'];?>" 
	              	data-id-user="<?=$_SESSION['rgr']['usuarioId']?>" 
	              	data-id-edital="<?=$vaga['edital'];?>" 
	              	class="btnInscr btnCadastrar btn btn-default btn-lg vb <?php if($qtyCv == 0){ echo "disabled";} ?>">Candidatar</a>
                <? } ?>
        <? } ?>
    </div>
</div>
<br /><br />
</body>
</html>