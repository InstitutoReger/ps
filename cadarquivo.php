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

	<div class="row text-center">

		<h1 class="text-center">Cadastrar arquivo</h1>

		<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>

		

        <form action="<?=$_SERVER['PHP_SELF'];?>?acao=cadArquivo" method="post" name="frmCadArq" id="frmCadArq" enctype="multipart/form-data">

            <div class="form-group">

				<div class="row">

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <label>Nome</label>

                        <input type="text" class="form-control" name="nome" id="nome" required />

					</div>

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <label>Arquivo</label>

                        <input type="file" class="form-control" accept="application/pdf" name="edital" id="edital" required />

					</div>

                </div>

            </div>

            

        	<div class="form-group">

				<div class="row">

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <label>Edital</label>

                        <?=listaEditais(NULL);?>

					</div>

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <label>Data</label>

                        <input type="text" name="data" id="data" class="form-control" required />

					</div>

                </div>

            </div>

            

            <div class="form-group">

			<input type="submit" name="submitCadArq" class="btn btn-default vb" value="Cadastrar arquivo" />

            </div>

        </form>



    </div>

</div>

<? } else {?>

		<? header('Location: index.php');?>

<? } ?>

</body>

</html>