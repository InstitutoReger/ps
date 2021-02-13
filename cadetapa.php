<? 
$acaolocal = 'cadEtRecurso';
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
		<h1 class="text-center">Cadastrar etapa de recurso</h1>
		<div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
		<? if($classecv != 'ok'){?>
        <form action="<?=$_SERVER['PHP_SELF'];?>?acao=cadEtapaRecurso" method="post" name="frmCadEtRec" id="frmCadEtRec">
            <div class="form-group">
				<div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Etapa</label>
						<select name="etapa" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Análise Curricular">Análise Curricular</option>
                            <option value="Aula teste">Aula teste</option>
                            <option value="Candidatura">Candidatura</option>
                            <option value="Candidatura e triagem">Candidatura e triagem</option>
                            <option value="Dinâmica de grupo">Dinâmica de grupo</option>
                            <option value="Entrevista">Entrevista</option>
                            <option value="Aula prática">Prova prática</option>
                        </select>
					</div>
                    
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Edital nº</label>
                        <select class="form-control" name="edital">
                            <? while($edital = $stmt->fetch(PDO::FETCH_ASSOC)){?>
                            <option value="<?=$edital['id'];?>"><?=$edital['nome'];?></option>
                            <? }?>
                        </select>
                    </div>
                </div>
            </div>
            
        	<div class="form-group">
				<div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Início (01/01/2001 08:08:08)</label>
						<input type="text" name="inicio"  class="form-control" id="datepicker" />
					</div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <label>Término (01/01/2001 08:08:08)</label>
						<input type="text" name="termino" class="form-control" id="datepicker2" />
					</div>
                </div>
            </div>
            
            <div class="form-group">
			<input type="submit" name="submitCadEtRec" class="btn btn-default vb" value="Cadastrar etapa de recurso" />
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