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
		<h1 class="text-center">Importar vagas</h1>
		<div class="avisoCV vc fw6 <?=$classev?>"><?=$avisoV;?></div>
		
        <? if (!$_POST || $_POST['inserirVG'] == 'Sim'){?>
            <? if(!$msg){?>
                <div class="alert alert-danger">Atenção! Confira atentamente o arquivo csv antes de fazer a importação! <b>Não é possível desfazer ou cancelar após enviar o arquivo!</b></div>
            <? } else {?>
                <div class="alert alert-success"><?php echo $msg;?></div>
            <? } ?>

        <form action="<?=$_SERVER['PHP_SELF'];?>?acao=importaCsv" method="post" name="frmImpVagas" id="frmImpVagas" enctype="multipart/form-data">
            <div class="col-md-12">
	            <div class="col-md-4">
	                <div class="form-group">
	                    <label for="csvfile">Arquivo CSV</label>
	                    <input type="file" accept=".csv" name="csvfile" id="csvfile" class="form-control" required="required">
	                </div>
	            </div>

	            <div class="col-md-4">
	            	<div class="form-group">
	            		<label>Inserir no banco de dados?</label>
	            		<select name="inserirVG" class="form-control">
	            			<option value=""> - </option>
	            			<option value="Sim"> Sim </option>
	            		</select>
	            	</div>
	            </div>

	            <div class="col-md-4">
		            <div class="form-group">
						<label>Edital</label>
		                <?=listaEditais(NULL);?>
		            </div>
		        </div>
		    </div>

            <div class="form-group">
			<input type="submit" name="submitCadVaga" class="btn btn-default vb" value="Importar vagas" />
            </div>
        </form>
        <? } else {

        $csv = $_FILES['csvfile']['tmp_name'];
        
        if (($handle = fopen($csv, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 2000, "\n")) !== FALSE) {
                $num = count($data);
        
                for ($c=0; $c < $num; $c++) {
                    $dados = $data[$c];
                    $d = explode(';',$dados);
                    
                    // verifica se a linha possui mais ou menos que 11 itens. Se sim, houve erro no preenchimento da planilha.
                    // os erros mais comuns são caracteres ; ou quebra de linha (alt+enter) dentro do conteúdo de uma célula
                    // cada quebra de linha é considerada fim de uma linha na planilha
                    // e cada ; é considerado como delimitador de uma célula
                    
					if(count($d) <> 9) { $erro = 'erro'; } else { $erro = '';}

                    echo "<pre class='".$erro."'>";
                    echo "<b>Cargo:</b> ".utf8_encode($d[0])."<br />";
                    echo "<b>Local:</b> ".utf8_encode($d[1])."<br />";
                    echo "<b>Atribuições:</b> ".utf8_encode($d[2])."<br />";
                    echo "<b>Formação e requisitos:</b> ".utf8_encode($d[3])."<br />";
                    echo "<b>Quantidade de vagas:</b> ".utf8_encode($d[4])."<br />";
                    echo "<b>Carga horária:</b> ".utf8_encode($d[5])."<br />";
                    echo "<b>Turno:</b> ".utf8_encode($d[6])."<br />";
                    echo "<b>Salário:</b> ".utf8_encode($d[7])."<br />";
                    echo "<b>Número da vaga:</b> ".utf8_encode($d[8])."<br />";
                    echo "<b>Edital:</b> ".$_POST['edital']."<br />";
                    echo "</pre>";
                }
            }
            fclose($handle);
        }
        }?>
    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>