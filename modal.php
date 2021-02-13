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