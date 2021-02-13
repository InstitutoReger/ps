<? $acaolocal = 'listaCandidatos2';?>

<? include('ctrl/ctrlSite.php');

if(!isset($_SESSION)) session_start();

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
	<div class="row">
        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
			<h2>Filtros de busca</h2>
            
            <div class="row sidebarSearch">
            
            	<form name="filtrosbusca" action="" method="post" id="frmFiltro">
					<div class="checkbox">
                        <label><input type="checkbox" value="sim" name="pcd" <? if($_POST['pcd'] == 'sim'){ echo 'checked';}?> /> Portador de necessidades especiais</label>
                    </div>
                    
                    <!--<div class="form-group">
						<label>Data de nascimento</label>
                        <input type="text" name="nascimento" class="form-control" value="<?=$_POST['nascimento'];?>" />
                    </div>-->
                    
                    <div class="form-group">
						<label>Formação</label>
                        <input type="text" name="formacao" class="form-control" value="<?=$_POST['formacao'];?>" />
                    </div>
                    
                    <div class="form-group">
						<label>Ordenar por</label>
                        <select name="ordem" class="form-control">
	                        <option value="">Selecione</option>
							<option value="nome" <? if($_POST['ordem'] == 'nome'){ echo 'selected';}?>>Nome</option>
							<option value="nome_curso" <? if($_POST['ordem'] == 'nome_curso'){ echo 'selected';}?>>Formação</option>
							<option value="nascimento" <? if($_POST['ordem'] == 'nascimento'){ echo 'selected';}?>>Data de nascimento</option>
							<option value="datainscricao" <? if($_POST['ordem'] == 'datainscricao'){ echo 'selected';}?>>Data de inscrição</option>
                        </select>
                        
                        <div class="radio">
                        <label class="radio-inline"><input type="radio" name="ord" value="DESC" <? if($_POST['ord'] == 'DESC' || empty($_POST['ord'])){ echo 'checked';}?>>Decrescente</label>
                        <label class="radio-inline"><input type="radio" name="ord" value="ASC" <? if($_POST['ord'] == 'ASC'){ echo 'checked';}?>>Ascendente</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    	<input type="reset" value="Limpar" class="btn btn-default btn-info btn-lg" onClick="window.location.href = window.location.href;" />
						<input type="submit" value="Filtrar" class="btn btn-default btn-lg vb" />
                    </div>
                </form>
                
            </div>
        </div>
        
        <div class="col-md-9">
		<h2 class="text-center">Lista de candidatos inscritos<br> Edital: <?=$ve['numEdital'];?> | Número da vaga: <?=$ve['numVg'];?></h2>
	        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celNome">Nome</th>
              <th class="celPrazo">Formação</th>
              <th class="celArquivo">Nascimento</th>
              <th class="celInscrever"></th>
			</tr>
            </thead>
            <tbody>
        <?	while($r = $lis->fetch(PDO::FETCH_ASSOC)){?>
				<tr>
                <td><?=$r['nome'];?></td>
                <td><?=$r['nome_curso'];?></td>
                <td><?=formataData($r['nascimento'], 'php');?></td>
                <td><a href="visualizacv.php?idCV=<?=$r['id_usuario'];?>" target="_blank" class="btn btn-default vb" style="color:#fff">Ver mais</a></td>
                </tr>
			<? }?>
			</tbody>
			</table>

        </div>
    </div>
</div>

<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>
