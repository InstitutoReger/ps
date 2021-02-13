<? $acaolocal = 'listaarquivos';?>

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
		<h1 class="text-center">Arquivos cadastrados</h1>
		<div class="avisoCV vc fw6"></div>
        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celNome2">Nome</th>
              <th class="celArquivo2">Data</th>
              <th class="celArquivo2">Edital</th>
              <th class="celArquivo2">Arquivo</th>
              <th class="celInscrever2"></th>
			</tr>
            </thead>

            <tbody>

        <? while($r = $arq->fetch(PDO::FETCH_ASSOC)){?>

			<tr class="listvg">
            	<td class="celNome2"><?=$r['nome'];?></td>
            	<td class="celArquivo2"><?=formataData($r['data'], 'php');?></td>
            	<td class="celArquivo2"><?=nomeEdital($r['id_edital']);?></td>
            	<td class="celArquivo2"><a href="pdf/<?=$r['arquivo'];?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a></td>
                <td class="celInscrever2">
					<a class="btn btn-info" href="editaarquivo.php?id=<?=$r['id'];?>">Editar</a>
                    <a class="btn btn-danger deletaarquivo" data-arq="<?=$r['arquivo'];?>" data-id="<?=$r['id'];?>" href="javascript:void(0)">Excluir</a>
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