<? $acaolocal = 'teste';?>

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
	<div class="row">
		<h1 class="text-center">Edital <?=$nomeedital?></h1>
        <table class="table table-bordered">
			<thead>
            	<th>Arquivo</th>
            </thead>
            <tbody>
            		<tr>
                    	<td class="arqEdital"><a href="pdf/<?=$arquivo;?>" target="_blank">Edital</a></td>
                    </tr>
            	<? while($a = $arq->fetch(PDO::FETCH_ASSOC)){?>
					<tr>
                        <td class="arqEdital"><a href="pdf/<?=$a['arquivo'];?>" target="_blank"><?=$a['nome'];?></a></td>
                    </tr>
                <? } ?>
                <? if ($rec->rowCount() > 0) {?>
                <tr>
                	<td class="arqEdital"><a href='recurso.php?idEdital=<?=$_REQUEST['idedital']?>'>Link para interposição de recurso</a></td>
                </tr>
                <? } ?>
            </tbody>
        </table>
    </div>

	<div class="row">
		<h1 class="text-center">Vagas do edital <?=$nomeedital;?></h1>
		<div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celArquivo">Número da vaga</th>
              <th class="celNome">Cargo</th>
              <th class="celPrazo">Formação e requisitos</th>
              <th class="celArquivo">Local</th>
              <th class="celInscrever"></th>
			</tr>
            </thead>

            <tbody>

        <? while($r = $lvg->fetch(PDO::FETCH_ASSOC)){?>

			<tr>
				<td class="celArquivo"><?=$r['numero'];?></td>
            	<td class="celNome"><?=$r['cargo'];?></td>
            	<td class="celPrazo"><?=$r['formacao'];?></td>
            	<td class="celArquivo"><?=$r['local'];?></td>
                <td class="celInscrever">
	               	<a href="detalhesvaga.php?idVaga=<?=$r['id'];?>"  class="btn btn-default vb">Mais informações</a>
                </td>
            </tr>

        <? } ?>

        </tbody>
		</table>
    </div>
</div>

</body>
</html>