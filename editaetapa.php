<? 
$acaolocal = 'editaEtapa';
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
		<h1 class="text-center">Editar etapa de recurso</h1>
		<div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
		<? if($classecv != 'ok'){?>
        <form action="<?=$_SERVER['PHP_SELF'];?>?acao=atualizaEtapaRecurso" method="post" name="frmCadEtRec" id="frmCadEtRec">
            <div class="form-group">
				<div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Etapa</label>
						<select name="etapa" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Análise Curricular" <? if ($r['nome'] == 'Análise Curricular') echo "selected";?>>Análise Curricular</option>
                            <option value="Aula teste" <? if ($r['nome'] == 'Aula teste') echo "selected";?>>Aula teste</option>
                            <option value="Candidatura" <? if ($r['nome'] == 'Candidatura') echo "selected";?>>Candidatura</option>
                            <option value="Candidatura e triagem" <? if ($r['nome'] == 'Candidatura e triagem') echo "selected";?>>Candidatura e triagem</option>
                            <option value="Aula teste" <? if ($r['nome'] == 'Dinâmica de grupo') echo "selected";?>>Dinâmica de grupo</option>
                            <option value="Aula teste" <? if ($r['nome'] == 'Entrevista') echo "selected";?>>Entrevista</option>
                            <option value="Aula prática" <? if ($r['nome'] == 'Aula prática') echo "selected";?>>Prova prática</option>
                        </select>
					</div>
                    
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Edital nº</label>
                        <select class="form-control" name="edital">
                            <? while($edital = $edt->fetch(PDO::FETCH_ASSOC)){?>
                            <option value="<?=$edital['id'];?>" <? if($r['idEdital'] == $edital['id']) echo "selected"; ?>><?=$edital['nome'];?></option>
                            <? }?>
                        </select>
                    </div>
                </div>
            </div>
            
        	<div class="form-group">
				<div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Início</label>
						<input type="text" name="inicio"  class="form-control" value="<?=formataDataHora2($r['inicio'], 'php');?>" id="datepicker" />
					</div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Término</label>
						<input type="text" name="termino" class="form-control" value="<?=formataDataHora2($r['termino'], 'php');?>" id="datepicker2" />
					</div>
                </div>
            </div>
            
            <div class="form-group">
            <input type="hidden" name="idEtapa" value="<?=$r['id'];?>"  />
			<input type="submit" name="submitCadEtRec" class="btn btn-default vb" value="Atualizar etapa de recurso" />
            </div>
        </form>

    </div>
</div>
<? } ?>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="css/timepicker.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<? echo '<script src="js/timepicker.js?' . date("YmdHis", filemtime("js/timepicker.js")) . '"></script>'; ?>
<? echo '<script src="js/calendario2.js?' . date("YmdHis", filemtime("js/calendario2.js")) . '"></script>'; ?>

</body>
</html>