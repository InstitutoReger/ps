<? $acaolocal = 'relatorioVagas';?>

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
		<h1 class="text-center">Relatório de inscrições por vaga</h1>
		<div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <table class="table table-bordered">
          <thead>
            <th class='col-md-1'>ID Edital</th>
            <th class='col-md-2'>Nome Edital</th>
            <th class='col-md-1'>Número vaga</th>
            <th class='col-md-3'>Cargo</th>
            <th class='col-md-2'>Qtd Vagas</th>
            <th class='col-md-2'>Local</th>
            <th class='col-md-1'>Candidatos</th>
          </thead>

          <tbody>
            <? while($r = $con->fetch(PDO::FETCH_ASSOC)){
              echo "<tr>";
                echo "<td>".$r['idEdital']."</td>";
                echo "<td>".$r['nomeEdital']."</td>";
                echo "<td>".$r['numero']."</td>";
                echo "<td>".$r['cargo']."</td>";
                echo "<td>".$r['vagas']."</td>";
                echo "<td>".$r['local']."</td>";
                echo "<td>".$r['numCandidatos']."</td>";
                $numTotal = $numTotal + $r['numCandidatos'];
              echo "</tr>";
            }
            echo "<tr><td colspan='4' class='text-right'><strong>Número de vagas: ".$con->rowCount()."</strong></td><td colspan='2'><strong>Número de candidatos: ".$numTotal."</strong></td></tr>";?>
          </tbody>
		    </table>
    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>

</body>
</html>