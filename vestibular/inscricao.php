<? include('../ctrl/ctrlSite.php');?>
<? verificaLogadoVest(); ?>
<? include('inc_header.php');?>
<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="../img/logo.png">
        <img src="../img/itego_sed_govgoias.jpg" class="isg">
    </div>
</header>

<div class="container mt30">
	<h2 class="text-center">Formulário de inscrição - Processo de Seleção Para Aproveitamento de Vagas Remanescentes ITEGO ACN 2017/2</h2>
    <h3 class="text-center">Curso Superior de Tecnologia em Gestão da Produção Industrial</h3>
	<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>
	<? include('frmVest.php');?>
</div>
</body>
</html>