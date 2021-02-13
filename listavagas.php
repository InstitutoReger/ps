<? $acaolocal = 'listavagas';?>
<? include('ctrl/ctrlSite.php');
verificaLogado();
include('inc_header.php');?>
<style type="text/css">
@media print {
  *,
  *:before,enter code here
  *:after {
    color: #000 !important;
    text-shadow: none !important;
    background: transparent !important;
    -webkit-box-shadow: none !important;
            box-shadow: none !important;
  }
  a,
  a:visited {
    text-decoration: underline;
  }
  a[href]:after {
    content: " (" attr(href) ")";
  }
  abbr[title]:after {
    content: " (" attr(title) ")";
  }
  a[href^="#"]:after,
  a[href^="javascript:"]:after {
    content: "";
  }
  pre,
  blockquote {
    border: 1px solid #999;

    page-break-inside: avoid;
  }
  thead {
    display: table-header-group;
  }
  tr,
  img {
    page-break-inside: avoid;
  }
  img {
    max-width: 100% !important;
  }
  p,
  h2,
  h3 {
    orphans: 3;
    widows: 3;
  }
  h2,
  h3 {
    page-break-after: avoid;
  }
  select {
    background: #fff !important;
  }
  .navbar {
    display: none;
  }
  .btn > .caret,
  .dropup > .btn > .caret {
    border-top-color: #000 !important;
  }
  .label {
    border: 1px solid #000;
  }
  .table {
    border-collapse: collapse !important;
  }
  .table td,
  .table th {
    background-color: #fff !important;
  }
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ddd !important;
  }
}
</style>
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
    <h1 class="text-center">Vagas do Edital (<?php echo $lis->rowCount();?>)</h1>
    <div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="col-md-1 text-center">Número da vaga</th>
              <th class="col-md-2 text-center">Edital</th>
              <th class="col-md-3">Cargo</th>
              <th class="col-md-4">Formação e requisitos</th>
              <th class="col-md-1 text-center">Arquivo</th>
              <th class="col-md-1"></th>
            </tr>
          </thead>

          <tbody>

            <? while($r = $lis->fetch(PDO::FETCH_ASSOC)){?>

            <tr class="listvg">
              <td class="text-center numVg"><?=$r['numero'];?></td>
              <td class="text-center nomeVg"><?=$r['nome'];?></td>
              <td class=""><?=$r['cargo'];?></td>
              <td class=""><?=$r['formacao'];?></td>
              <td class="text-center"><?=buscaEdital($r['edital']);?></td>
                      
              <td class="">
                <a class="btn btn-success" href="listacandidatos.php?idPS=<?=$r['idVG'];?>" style="margin-bottom:5px">Listar candidatos</a>   
                <a class="btn btn-primary" href="editarvaga.php?id=<?=$r['idVG'];?>">Editar</a>
                <a class="btn btn-danger deletavaga" data-id="<?=$r['idVG'];?>" href="javascript:void(0)">Excluir</a>
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