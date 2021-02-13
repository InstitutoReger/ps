<?php include('ctrl/ctrlSite.php');

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

<div class="container">
	<div class="row">
		<h1 class="text-center">Cadastro de currículo</h1>
	</div>

    <div class="row">
		<div class="avisoCV vc fw6 <?=$classecv;?>"><?=$avisoCV;?></div>
    </div>

    <div class="row">
        <div id="rootwizard">
            <div class="navbar">
              <div class="navbar-inner">
                    <ul class="navetapas">
                        <li><a href="#tab1" data-toggle="tab">Informações pessoais</a></li>
                        <li><a href="#tab2" data-toggle="tab">Documentos complementares</a></li>
                        <li><a href="#tab3" data-toggle="tab">Formação acadêmica</a></li>
                        <li><a href="#tab4" data-toggle="tab">Informações adicionais</a></li>
                        <li><a href="#tab5" data-toggle="tab">Experiência profissional</a></li>
                        <li><a href="#tab6" data-toggle="tab">Capacitações profissionais/Cursos</a></li>
                        <li><a href="#tab7" data-toggle="tab">Outras informações</a></li>
                    </ul>
              </div>
            </div>

            <div class="tab-content  col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="tab-pane" id="tab1">
                <? include('frm1.php');?>
                </div>

                <div class="tab-pane" id="tab2">
                <? include('frm2.php');?>
                </div>

                <div class="tab-pane" id="tab3">
                <? include('frm3.php');?>
                </div>

                <div class="tab-pane" id="tab4">
                <? include('frm4.php');?>
                </div>

                <div class="tab-pane" id="tab5">
                <? include('frm5.php');?>
                </div>

                <div class="tab-pane" id="tab6">
                <? include('frm6.php');?>
                </div>

                <div class="tab-pane" id="tab7">
                <? include('frm7.php');?>
                </div>

                <ul class="pager wizard">
                    <li class="previous"><a href="#">Anterior</a></li>
                    <li class="next"><a href="#">Próxima</a></li>
                </ul>

            </div>
        </div>
	</div>
</div>

</body>
</html>