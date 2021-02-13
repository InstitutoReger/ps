<? $acaolocal = 'listarecursos';?>
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
  <div class="row" id="listaRecPorEdital">
    <h1 class="text-center">Recursos recebidos</h1>
    <div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <table class="table table-bordered">
        <thead>
          <tr>
             <td class="col-md-2 col-lg-2 col-sm-2 col-xs-2"><strong>Edital</strong></td>
             <td class="col-md-10 col-lg-10 col-sm-10 col-xs-10 text-center"><strong>Ações</strong></td>
          </tr>
        </thead>
        <tbody>

        <? while($r = $stmt->fetch(PDO::FETCH_ASSOC)){?>
          <tr class="listvg">
            <td class="nomeEdital"><?=$r['nome'];?></td>
            <td class="text-center">
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="1">Análise Curricular</a>
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="2">Aula Teste</a>
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="4">Candidatura</a>
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="3">Candidatura e Triagem</a>
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="6">Dinâmica de Grupo</a>
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="7">Entrevista</a>
              <a href="#" class="btn btn-sm btn-primary   listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="5">Prova Prática</a>
              <a href="#" class="btn btn-sm btn-danger vb listaRecursosEdital" data-edital="<?=$r['idEdital'];?>" data-etapa="0">Listar todos</a>
            </td>
          </tr>
        <? } ?>
        </tbody>
    </table>
  </div>

  <!-- receive data from ajax -->
  <div class="listagemRecursos">
  </div>
</div>
<? } else {?>
    <? header('Location: index.php');?>
<? } ?>
</body>
</html>