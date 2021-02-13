<? $acaolocal = 'listaCandidatos';?>
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
    <div class="avisoCV alert fw6"></div>
  </div>

  <div class="row">
    <h1 class="text-center">Lista de candidatos inscritos</h1>
    <h4 class="text-center">
      <b>Edital:</b> <span id="edital"><?=$infoVaga['nome'];?></span> | 
      <b>Número da vaga:</b> <?=$infoVaga['numero'];?> | 
      <b>Cargo:</b> <span id="cargo"><?=$infoVaga['cargo'];?></span> |
      <b>Número de inscritos:</b> <span id="numInscricoes"><?=$res2->rowCount()?></span>
    </h4>

    <div class="col-md-12">
      <table class="table table-bordered">
      <thead>
        <tr>
          <th class="col-md-4">Nome</th>
          <th class="col-md-4">Formação</th>
          <th class="col-md-1">CPF</th>
          <th class="col-md-1">Nascimento</th>
          <th class="col-md-2"></th>
        </tr>
      </thead>
  
      <tbody>
        <?  while($r = $res->fetch(PDO::FETCH_ASSOC)){
          $pcd = '';
          if($r['pcd'] == 'Sim') {$pcd = '<small class="listapcd">pcd</small>';}


          echo '
            <tr class="listaInscricoes">
              <td class="nomeCandidato">'.$r['nome'].$pcd.'</td>
              <td>'.$r['nome_curso'].' <span style="color:#c00">('.$r['qtyCursos'].')</span></td>
              <td>'.$r['cpf'].'</td>
              <td>'.formataData($r['nascimento'], 'php').'</td>
              <td>
                <a href="visualizacv.php?idCV='.$r['id_usuario'].'" target="_blank" class="btn btn-primary">Ver mais</a>
                <a href="#" data-id-vaga="'.$_REQUEST["idPS"].'" data-id-usuario="'.$r['id_usuario'].'" class="btn btn-default vb deletainscricao" style="color:#fff">Excluir</a>
              </td>
            </tr>
          ';
        }?>
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