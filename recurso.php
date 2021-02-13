<?php $acaolocal = 'frmRecurso';?>
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


<? include('inc_menu.php');?>


<div class="container">
	<div class="row">
		<h1 class="text-center">Formulário para interposição de recursos</h1>
		<div class="avisoCV vc fw6 <?=$classecv?>"><?=$avisoCV;?></div>
        <? if($classecv != 'ok'){?>
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>?acao=frmRecurso" onsubmit="return validaFrmRecurso(this);">
            <div class="form-group">
                <label>Edital nº</label>
                <select class="form-control" name="edital">
					<option value="<?=$edital['id'];?>"><?=$edital['nome'];?></option>
                </select>
            </div>


            <div class="form-group">
				<label>para o preenchimento do cargo de</label>
                <input type="text" class="form-control" name="cargo" />
            </div>

            <div class="form-group">
				<label>Número de ordem da vaga</label>
                <input type="text" class="form-control" name="vaga"/>
            </div>


            <div class="form-group">
				<label>E-mail</label>
                <input type="text" class="form-control" name="email" value="" />
            </div>


            <div class="form-group">
				<label>Etapa:</label>
                <select name="etapa" class="form-control">
                    <option value="<?=$etp['nome'];?>"><?=$etp['nome'];?></option>
                </select>
            </div>

            <hr />

            <div class="form-group">
				<label>Nome do candidato:</label>
                <input type="text" class="form-control" name="nome" />
            </div>

            

            <div class="form-group">
				<label>Justificativa:</label>
                <textarea class="form-control" name="justificativa"></textarea>
            </div>

            

            <div class="form-group">
            	<input type="checkbox" id="checkConcordo" name="concordo" /> Declaro serem verdadeiras as informações descritas acima
            </div>

            
            <?php if(!empty($_GET['idEdital'])){?>
            <div class="form-group">
                <label>Anexar documentos comprobatórios, quando necessário. </label>
                <div id="mulitplefileuploader">Anexar arquivos</div>
                <div id="status"></div>
            </div>
            <?php }?>


            <div class="form-group">
            	<input type="hidden" name="idRecurso" value="<?=$idd;?>" />
				<input type="submit" class="btn btn-default vb btn-lg" disabled="disabled" id="btnCadRecurso" value="Cadastrar recurso" />
            </div>
        </form>
        <? } ?>
    </div>
</div>



<script>

$(document).ready(function()

{

var idrecurso = <?=$idd;?>;

var settings = {
	url: "ctrl/ctrlSite.php?acao=arquivosRecurso&idrecurso="+idrecurso,
	method: "POST",
	allowedTypes:"doc,pdf,docx",
	fileName: "myfile",
	multiple: true,
	onSuccess:function(files,data,xhr)
	{
		$("#status").html("<font color='green'>Arquivos anexados com sucesso</font>");
	},

	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload dos arquivos falhou.</font>");
	}
}
$("#mulitplefileuploader").uploadFile(settings);
});



$("#checkConcordo").attr('checked', !$("#btnCadRecurso")[0].disabled);
$("#checkConcordo").click(function(){   

    $("#btnCadRecurso").attr('disabled', !this.checked)
});
</script>
</body>
</html>