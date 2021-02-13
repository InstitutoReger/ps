<?
$acaolocal = 'listainscritos';
include('ctrl/ctrlSite.php');
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
		<? if($conta !=0) { ?>
		<h1 class="text-center">Lista inscritos</h1>
		<div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celNome">Nome</th>
              <th class="celPrazo">CPF</th>
              <th class="celArquivo">Nascimento</th>
              <th class="celInscrever"><a class="btn btn-primary" href="imprimeInscVest.php">Imprimir inscritos</a></th>
			</tr>
            </thead>

            <tbody>
        <? while($r = $ins->fetch(PDO::FETCH_ASSOC)){?>
        	<tr>
            	<td class="celNome"><?=$r['nome'];?></td>
                <td class="celPrazo"><?=$r['cpf'];?></td>
                <td class="celArquivo"><?=$r['nascimento'];?></td>
                <td class="celInscrever"><a href="detalhesinscrito.php?id=<?=$r['id'];?>" class="btn btn-default vb">mais informações</a></td>
            </tr>
        <? } ?>

        </tbody>
		</table>
<? } else { echo "<div class='avisoCV vc fw6 erro'>Nenhum inscrito encontrado</div>"; } ?>
    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>