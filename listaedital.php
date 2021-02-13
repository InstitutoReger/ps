<? $acaolocal = 'listaeditais';?>

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
  <div class="row">
    <h1 class="text-center">Editais cadastrados</h1>
    <div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="col-md-4">Nome</th>
              <th class="col-md-1 text-center">Número</th>
              <th class="col-md-1 text-center">Início</th>
              <th class="col-md-1 text-center">Término</th>
              <th class="col-md-1 text-center">Arquivo</th>
              <th class="col-md-4"></th>
            </tr>
          </thead>

          <tbody>

            <? while($r = $edt->fetch(PDO::FETCH_ASSOC)){?>

              <tr class="listvg">
                <td><?=$r['nome'];?></td>
                <td class="text-center"><?=$r['numero'];?></td>
                <td class="text-center"><?=formataData($r['inicio'], 'php');?></td>
                <td class="text-center"><?=formataData($r['termino'], 'php');?></td>
                <td class="text-center"><a href="pdf/<?=$r['edital'];?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a></td>
                <td>
                  <a class="btn btn-info" href="listavagas.php?idEdital=<?=$r['id'];?>">Vagas</a>
                  <a class="btn btn-success" href="relatorioedital.php?idEdital=<?=$r['id'];?>">Relatório</a>
                  <a class="btn btn-primary" href="editaredital.php?id=<?=$r['id'];?>">Editar</a>
                  <a class="btn btn-danger deletaedital" data-id="<?=$r['id'];?>" href="javascript:void(0)">Excluir</a>
                </td>
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