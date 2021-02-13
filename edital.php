<? $acaolocal = 'detalhesEdital'; ?>
<? include('ctrl/ctrlSite.php');?>
<? apagaSessao();?>
<? include('inc_header.php');?>
<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo.png">
    </div>
</header>

<div class="container mt30">
	<div class="row text-center">
		<a href="javascript:void(0);" data-toggle="modal" data-target=".modal" class="btn btn-default btn-lg vb txtbranco">Faça login ou cadastre-se para candidatar</a>
	</div>
</div>

<div class="container mt30">
	<h1 class="text-center">Arquivos do edital <?php echo $edital['numero'];?></h1>
	<table class="table table-bordered">
		<thead>
			<th class="col-md-8">Nome</th>
			<th class="col-md-2 text-center">Data</th>
			<th class="col-md-2 text-center">Arquivo</th>
		</thead>
		<tbody>
				<tr>
					<td>Edital <?=$edital['numero']?></td>
					<td></td>
					<td class="text-center vis"><a href="pdf/<?=$edital['edital'];?>" target="_blank">Baixar arquivo</a></td>
				</tr>
			<?php while($a = $arq->fetch(PDO::FETCH_ASSOC)){?>
				<tr>
					<td><?=$a['nome'];?></td>
					<td class="text-center"><?=formataData($a['data'], 'php');?></td>
					<td class="text-center vis"><a href="pdf/<?=$a['arquivo']?>" target="_blank">Baixar arquivo</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<div class="container mt30">
<?php if($numDet > 0){?>
<h1 class="text-center">Vagas do edital <?=$edital['numero'];?></h1>
	<table class="table table-bordered">
		<thead>
			<th class="col-md-1 text-center">Nº do Edital</th>
			<th class="col-md-1 text-center">Nº da vaga</th>
			<th class="col-md-2 text-center">Cargo</th>
			<th class="col-md-4 text-center">Formação</th>
			<th class="col-md-3 text-center">Local</th>
			<th class="col-md-1 text-center">Edital</th>
		</thead>
		<tbody>
	<? while($r = $det->fetch(PDO::FETCH_ASSOC)){?>
		<tr>
			<td class="text-center"><?php echo $r['numEdital'];?></td>
			<td class="text-center"><?php echo $r['numVaga'];?></td>
			<td class="text-center"><?php echo $r['cargo'];?></td>
			<td class="text-center"><?php echo $r['formacao'];?></td>
			<td class="text-center"><?php echo $r['local'];?></td>
			<td class="text-center vis"><a href="pdf/<?=$r['pdfEdital'];?>" target="_blank">Visualizar <span class="glyphicon glyphicon-download-alt"></span></a></td>
		</tr>
	<? }?>
	</tbody>
	</table>
<? } else {?>
<div class="alert alert-danger">Não há vagas cadastradas neste edital</div>
<? } ?>
</div>

<?php include('modal.php');?>
</body>
</html>