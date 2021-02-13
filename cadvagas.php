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

		<h1 class="text-center">Cadastrar vagas</h1>

		<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>

		

        <form action="<?=$_SERVER['PHP_SELF'];?>?acao=cadVaga" method="post" name="frmcadvaga" id="frmcadvaga" onSubmit="return validacadvaga(this);">

            <div class="form-group">

				<div class="row">

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <label>Cargo</label>

                        <input type="text" class="form-control" name="cargo" id="nomevaga" required />

					</div>

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <label>Local</label>

                        <input type="text" class="form-control" name="local" id="local" required />

					</div>

                </div>

            </div>

            

            <div class="form-group">

				<label>Atribuições</label>

                <textarea class="form-control" name="atribuicoes"></textarea>

            </div>

            

            <div class="form-group">

				<label>Formação e requisitos</label>

                <textarea class="form-control" name="formacao"></textarea>

            </div>

            

            <div class="form-group">

				<div class="row">

                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">

                    	<label>Quantidade de vagas</label>

                    	<input type="text" class="form-control" name="vagas" />

                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">

                    	<label>Número do edital</label>

                    	<input type="text" class="form-control" name="nedital" />

                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">

                    	<label>Número da vaga</label>

                    	<input type="text" class="form-control" name="nvaga" />

                    </div>

                </div>

            </div>



            <div class="form-group">

				<div class="row">

                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">

                    	<label>Carga horária semanal</label>

                    	<input type="text" class="form-control" name="cargah" />

                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">

                    	<label>Turno</label>

                    	<input type="text" class="form-control" name="turno" />

                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">

                    	<label>Salário</label>

                    	<input type="text" class="form-control" name="salario" />

                    </div>

                </div>

            </div>

            
     

            

        	<div class="form-group">

				<label>Edital</label>

                <?=listaEditais(NULL);?>

            </div>

            

            <div class="form-group">

			<input type="submit" name="submitCadVaga" class="btn btn-default vb" value="Cadastrar vaga" />

            </div>

        </form>



    </div>

</div>

<? } else {?>

		<? header('Location: index.php');?>

<? } ?>

</body>

</html>