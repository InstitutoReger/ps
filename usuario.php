<? $acaolocal = 'inicialUsu';?>
<? include('ctrl/ctrlSite.php');
if($_GET['pag'] == 'cadcv'){
	$avisoCV = 'Seu currículo foi cadastrado';
	$classecv = 'ok';
}
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
  <div class="row">
    <div class="avisoCV vc fw6 <?=$classecv?> text-center"><?=$avisoCV;?></div>

      <h1 class="text-center">Processos seletivos em andamento</h1>
      <? if($numPsAberto != 0){?>
      <table class="table table-bordered">
          <thead>
            <tr>
              <th class="celArquivo">Número do edital</th>
              <th class="celArquivo">Nome do edital</th>
              <th class="celArquivo">Quantidade de cargos</th>
              <th class="celArquivo">Quantidade de vagas</th>
              <th class="celArquivo">Edital</th>
              <th class="celNome"></th>
            </tr>
          </thead>
          <tbody>
            <? while ($v = $lisv->fetch(PDO::FETCH_ASSOC)) {?>
              <tr>
                  <td class="celArquivo"><?=$v['numero'];?></td>
                  <td class="celArquivo"><?=$v['nome'];?></td>
                  <td class="celArquivo"><?=numVagasEdital('cargos', $v['id']);?></td>
                  <td class="celArquivo"><?=numVagasEdital('vagas', $v['id']);?></td>
                  <td class="celArquivo"><a href="pdf/<?=$v['edital'];?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a></td>
                  <td class="celNome text-center"><a href="listavg.php?idedital=<?=$v['id'];?>" class="btn btn-primary txtbranco">Clique para ver mais detalhes</a></td>
              </tr>
            <? }?>
          </tbody>
      </table>
      <? } else { ?>
        <div class="alert alert-danger text-center">No momento não há processo seletivos em andamento</div>
      <? } ?>
  </div>
</div>

<div class="container">
	<div class="row">
		<h1 class="text-center">Processos seletivos finalizados</h1>
        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celArquivo">Número do edital</th>
              <th class="celArquivo">Nome do edital</th>
              <th class="celArquivo">Quantidade de cargos</th>
              <th class="celArquivo">Quantidade de vagas</th>
              <th class="celArquivo">Edital</th>
              <th class="celNome"></th>
			</tr>
            </thead>

            <tbody>

        <? while($r = $lis->fetch(PDO::FETCH_ASSOC)){?>

			<tr>
				<td class="celArquivo"><?=$r['numero'];?></td>
            	<td class="celArquivo"><?=$r['nome'];?></td>
            	<td class="celArquivo"><?=numVagasEdital('cargos',$r['id']);?></td>
            	<td class="celArquivo"><?=numVagasEdital('vagas',$r['id']);?></td>
            	<td class="celArquivo"><a href="pdf/<?=$r['edital'];?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a></td>
				<td class="celNome text-center"><a href="listavg.php?idedital=<?=$r['id'];?>" class="btn btn-primary txtbranco">Clique para ver mais detalhes</a></td>
            </tr>

        <? } ?>

        </tbody>
		</table>
    </div>
</div>

</body>
</html>