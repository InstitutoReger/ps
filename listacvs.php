<?
$acaolocal = 'listacvs';
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
  <div class="row">
    <h1 class="text-center">Lista de currículos cadastrados (<? echo $lcv->rowCount();?>)</h1>
    <div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
    
    <nav class="navbar navbar-default">
      <div class="container-fluid">

        <form class="navbar-form navbar-left" name="frmBuscaCandidatos" action="<?=$_SERVER['PHP_SELF']?>">
          <div class="form-group">
            <input type="text" class="form-control" name="nome_candidato" placeholder="Nome" value="<?php echo $_REQUEST['nome_candidato']?>">
          </div>
          
          <div class="form-group">
            <input type="text" class="form-control" name="formacao_candidato" placeholder="Formação" value="<?php echo $_REQUEST['formacao_candidato']?>">
          </div>

          <div class="form-group">
            <select class="form-control" name="pcd_candidato">
              <option value="">PCD</option>
              <option value="Sim" <?php if ($_REQUEST['pcd_candidato'] == 'Sim'){ echo 'selected';}?>>Sim</option>
              <option value="Não" <?php if ($_REQUEST['pcd_candidato'] == 'Não'){ echo 'selected';}?>>Não</option>
            </select>
          </div>

          <div class="form-group" id="selectEditais">
            <?=listaEditais(NULL);?>
          </div>

          <div class="form-group">
            <select class="form-control" name="ordenacao">
              <option value="">Ordenação</option>
              <option value="ASC" <?php if ($_REQUEST['ordenacao'] == 'ASC'){ echo 'selected';}?>>Ascendente</option>
              <option value="DESC" <?php if ($_REQUEST['ordenacao'] == 'DESC'){ echo 'selected';}?>>Descendente</option>
            </select>
          </div>

          <input type="hidden" name="formName" value="frmBuscaCandidatos" />
          <button type="reset" class="btn btn-warning" onClick="window.location.href = 'listacvs.php';">Limpar</button>
          <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

      </div>
    </nav>

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
      <? while($r = $lcv->fetch(PDO::FETCH_ASSOC)){?>
        <tr>
          <td><?php echo $r['nome'];?></td>
          <?php 
            if($r['qtyFormacoes'] > 1) {$pluscurso = " +1";}
            if($r['qtyFormacoes'] == 1){$pluscurso = "";}
            if($r['qtyFormacoes'] == 0){$pluscurso = "--";}
          ?>
          <td><?php echo $r['nome_curso'];?><?php echo "<span class='vc'>".$pluscurso."</span>";?></td>
          <td><?php echo formataData($r['nascimento'],'php');?></td>
          <td class="celInscrever"><a href="visualizacv.php?idCV=<?php echo $r['id'];?>" target="_blank" class="btn btn-default vb">Ver mais</a></td>
        </tr>
      <? } ?>
      </tbody>
    </table>
    </div>
  </div>
<? } else {?>
  <? header('Location: index.php');?>
<? } ?>
</body>
</html>