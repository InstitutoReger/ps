<? 
$acaolocal = 'detalhesRec';
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
		<h1 class="text-center">Detalhes do recurso</h1>
	</div>

    <div class="row">
		<strong>Nome: </strong><?=$r['nome'];?><br>
		<strong>Edital: </strong><?=$r['edital'];?><br>
		<strong>Cargo: </strong><?=$r['cargo'];?><br>
		<strong>Vaga: </strong><?=$r['vaga'];?><br>
		<strong>Email: </strong><?=$r['email'];?><br>
		<strong>Etapa: </strong><?=$r['etapa'];?><br>
		<strong>Justificativa: </strong><?=$r['justificativa'];?><br><br>
	</div>
    
    <div class="row">
    <strong>Arquivo(s): </strong><br>
    	<? $file = 1;?>
		<? while($r = $stmt2->fetch(PDO::FETCH_ASSOC)){
			echo "<a href='https://institutoreger.org.br/processoseletivo/recursos/".$r['arquivo']."' target='_blank'>Arquivo".$file." <span class='glyphicon glyphicon-download-alt'></span></a><br>";
			$file++;
        } ?>
    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>