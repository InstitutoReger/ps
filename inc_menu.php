<nav class="navbar navbar-inverse container mt20">
	<div class="row">
		<ul class="nav navbar-nav">
			<li><a href="usuario.php">Home</a></li>

            <? if(!verificaNivelUser()){ ?>
			<li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Currículo <span class="caret"></span></a>
                <ul class="dropdown-menu">
		            <? if($numcv == 0){?>
                    <li><a href="cadcv.php">Cadastrar</a></li>
        			<? } else {?>
                    <li><a href="edtcv.php">Atualizar</a></li>
                    <li><a href="geraCV.php?id=<?php echo $_SESSION['rgr']['usuarioId']?>">Gerar Currículo</a></li>
                    <? } ?>
                </ul>
            </li>
            <li><a href="usuario.php">Vagas</a></li>
			<? } ?>
            <? if(verificaNivelUser()){ ?>
			<li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Vagas <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="cadvagas.php">Cadastrar</a></li>
                    <li><a href="listaedital.php">Listar</a></li>
                    <li><a href="importavagas.php">Importar</a></li>
                </ul>
            </li>
			
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Edital <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="cadedital.php">Cadastrar</a></li>
                    <li><a href="listaedital.php">Listar</a></li>
                </ul>
            </li>

		
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Arquivos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="cadarquivo.php">Cadastrar</a></li>
                    <li><a href="listaarquivos.php">Listar</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Etapas <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="cadetapa.php">Cadastrar</a></li>
                    <li><a href="listaetapas.php">Listar</a></li>
                </ul>
            </li>
                        
			<li><a href="listarecursos.php">Recursos</a></li>
            <li><a href="listacvs.php">Listar currículos</a></li>
            <li><a href="listainscritos.php">Inscritos vestibular</a></li>
            <? } ?>
        </ul>
    </div>
</nav>