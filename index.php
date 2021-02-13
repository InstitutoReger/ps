<? $acaolocal = 'inicial'; ?>
<? include('ctrl/ctrlSite.php');?>
<? apagaSessao();?>
<? include('inc_header.php');?>
<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo.png">
    </div>
</header>

<div class="container mt30">
  <div class="alert alert-info">
    INFORMATIVO PARA INSCRIÇÃO:  Neste espaço o candidato deverá ler o edital ao qual tem interesse (em anexo). Caso queira se candidatar em algum edital, clicar em FAÇA LOGIN PARA SE CANDIDATAR. Digitar o seu e-mail e uma senha para ACESSAR CURRÍCULO, caso já tenha o seu currículo em nosso banco de dados; ou clicar em CADASTRE SEU CURRÍCULO. Após finalizar o cadastro, clicar em vagas, localizar e escolher o edital. Clicar em VER MAIS DETALHES,  escolha a vaga, clique em MAIS INFORMAÇÕES. Ler e marcar o termo de aceite, e em seguida, clicar no botão CANDIDATAR
  </div>
</div>

<div class="container">
  <div class="row text-center">
    <a href="javascript:void(0);" data-toggle="modal" data-target=".modal" class="btn btn-default btn-lg vb txtbranco">Faça login ou cadastre-se para candidatar</a>
    <h1 class="text-center">Processos seletivos em andamento</h1>
    </div>
        <div class="row">
          <? if($numPsAberto != 0){?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="celArquivo">Número do edital</th>
              <th class="celArquivo">Nome do edital</th>
              <th class="celArquivo">Quantidade de cargos</th>
              <th class="celArquivo">Quantidade de vagas</th>
              <th class="celArquivo">Edital</th>
              <th class="celArquivo"></th>
            </tr>
          </thead>
          
          <tbody>
            <? while($r = $listav->fetch(PDO::FETCH_ASSOC)){?>
              <tr>
                <td class="celArquivo"><?=$r['numero'];?></td>
                <td class="celArquivo"><?=$r['nome'];?></td>
                <td class="celArquivo"><?=numVagasEdital('cargos',$r['id']);?></td>
                <td class="celArquivo"><?=numVagasEdital('vagas',$r['id']);?></td>
                <td class="celArquivo vis"><a href="pdf/<?=$r['edital'];?>" target="_blank">Visualizar <span class="glyphicon glyphicon-download-alt"></span></a></td>
                <td class="text-center"><a class="btn btn-danger vb" href="edital.php?numero=<?=$r['numero'];?>&id=<?=$r['id']?>">Mais informações</td>
              </tr>
            <? } ?>
          </tbody>
        </table>
        <? } else {?>
          <div class="alert alert-danger text-center">No momento não há processo seletivos em andamento</div>
        <? }?>
  </div>
</div>

<div class="container">
    <div class="row text-center">
      <h1 class="text-center">Processos seletivos finalizados</h1>
    </div>
        <div class="row">
        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celArquivo">Número do edital</th>
              <th class="celArquivo">Nome do edital</th>
              <th class="celArquivo">Quantidade de cargos</th>
              <th class="celArquivo">Quantidade de vagas</th>
              <th class="celArquivo">Edital</th>
              <th class="celArquivo"></th>
			</tr>
            </thead>
            <tbody>
        <? while($r = $listaf->fetch(PDO::FETCH_ASSOC)){?>
			<tr>
				<td class="celArquivo"><?=$r['numero'];?></td>
        <td class="celArquivo"><?=$r['nome'];?></td>
        <td class="celArquivo"><?=numVagasEdital('cargos',$r['id']);?></td>
        <td class="celArquivo"><?=numVagasEdital('vagas',$r['id']);?></td>
        <td class="celArquivo vis"><a href="pdf/<?=$r['edital'];?>" target="_blank">Visualizar <span class="glyphicon glyphicon-download-alt"></span></a></td>
        <td class="text-center"><a class="btn btn-danger vb" href="edital.php?numero=<?=$r['numero'];?>&id=<?=$r['id']?>">Mais informações</td>
      </tr>
        <? } ?>
        </tbody>
		</table>
  </div>
</div>

<a class="loginadm vb" data-toggle="modal" data-target=".modal"><span class="glyphicon glyphicon-lock"></span></a>
<?php include('modal.php');?>

</body>
</html>
<!-- lw -->