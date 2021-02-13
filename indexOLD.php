<? $acaolocal = 'listaProcSe'; ?>
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
INFORMATIVO PARA INSCRIÇÃO: os candidatos deverão verificar o cargo ao qual tem interesse, ler o Edital que está anexo e fazer login. Digitar o seu e-mail e uma senha para acessar seu currículo ou clicar em cadastre seu currículo para iniciar seu cadastro. Após finalizar o cadastro, clicar em vagas, localizar e escolher a vaga, clicar em mais informações. Ler e marcar o termo de aceite, e em seguida, clicar no botão candidatar.
	</div>
</div>

<div class="container">
	<div class="row text-center">
		<h1 class="text-center">Processos seletivos em andamento</h1>
        <br><br>
        <a href="javascript:void(0);" data-toggle="modal" data-target=".modal" class="btn btn-default btn-lg vb txtbranco">Faça login para candidatar</a>
        <br><br>
    </div>
        <div class="row">
        <table class="table table-bordered">
		  <thead>
           	<tr>
              <th class="celArquivo">Número da vaga</th>
              <th class="celNome">Cargo</th>
              <th class="celPrazo">Formação e requisitos</th>
              <th class="celArquivo">Local</th>
              <th class="celArquivo">Edital</th>
			</tr>
            </thead>
            <tbody>
        <? while($r = $lis->fetch(PDO::FETCH_ASSOC)){?>
			<tr>
				<td class="celArquivo"><?=$r['numero'];?></td>
            	<td class="celNome"><?=$r['cargo'];?></td>
            	<td class="celPrazo"><?=$r['formacao'];?></td>
            	<td class="celArquivo"><?=$r['local'];?></td>
            	<td class="celArquivo"><a href="pdf/<?=$r['edital'];?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a></td>
            </tr>
        <? } ?>
        </tbody>
		</table>
	<div class="row text-center">
        <br><br>
        <a href="javascript:void(0);" data-toggle="modal" data-target=".modal" class="btn btn-default btn-lg vb txtbranco">Faça login para candidatar</a>
        <br><br>
    </div>
    </div>
</div>
<a class="loginadm vb" data-toggle="modal" data-target=".modal"><span class="glyphicon glyphicon-lock"></span></a>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Cadastre seu currículo ou faça login</h4>
      </div>
      <div class="modal-body">
      	<div class="row text-center">
	        <a href="acesso.php" class="btn btn-lg btn-primary">Cadastre seu currículo</a>
        </div>
        
        <div class="row text-center mt10">ou</div>
        
        <div class="row">
            <form method="post" name="loginPainel" id="loginPainel" onSubmit="return validalogin(this);" action="<?=$_SERVER['PHP_SELF'].'?acao=login';?>">
        
                <div id="msgerro"></div>
        
                <div class="form-group">
                    <label for="user">E-mail</label>
                    <input type="text" name="user" id="user" class="form-control" placeholder="Email" autofocus />
                </div>
                    
                <div class="form-group">
                    <label for="userpwd">Senha</label>
                    <input type="password" name="userpwd" id="userpwd" class="form-control" placeholder="Senha" />
                </div>
                
                <div class="form-group">
                <a href="recsenha.php">Esqueci minha senha</a><br /><br />
                    <input type="submit" class="btn btn-default vb" value="Acessar currículo" />
                </div>
            </form>
        </div>
      </div>
   </div>
 </div>
</div>

</body>
</html>