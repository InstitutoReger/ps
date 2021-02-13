<?
$acaolocal = "geraPdfCv";
include('ctrl/ctrlSite.php');

verificaLogado();

include('inc_header.php');?>
<? echo '<link href="css/print.css?' . date("YmdHis", filemtime("css/print.css")) . '" type="text/css" rel="stylesheet" />'; ?>
<script>
function imprime() {
    if(document.getElementById('declaro').checked){
        $("#cxDeclaro").removeClass("alert alert-danger");
        window.print();    
    } else {
        document.getElementById("declaro").scrollIntoView();
        alert('É obrigatório marcar o termo de responsabilidade');
        $("#cxDeclaro").addClass("alert alert-danger");
    }
}

$(document).bind("keyup keydown", function(e){
    if(e.ctrlKey && e.keyCode == 80){
        if(!document.getElementById('declaro').checked){

            document.getElementById("declaro").scrollIntoView();
            alert('É obrigatório marcar o termo de responsabilidade');
            $("#cxDeclaro").addClass("alert alert-danger");
            return false;
        } else {
            $("#cxDeclaro").removeClass("alert alert-danger");
        }
    }
});

</script>


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

	<!-- AÇÕES -->
	<button class="btn btn-danger btnPrintCv"  onclick="imprime()">Clique para imprimir seu currículo <span class="glyphicon glyphicon-print"></span></button>

	<!-- INFORMAÇÕES PESSOAIS -->
	<h3 class="titCv">Informações pessoais</h3>
	<strong>Nome</strong>: <?=$cvp['nome'];?><br />
    <strong>E-mail</strong>: <?=$cvm['email'];?><br />
    <strong>Gênero</strong>: <?=$cvp['genero'];?><br />
    <strong>Estado Civil</strong>: <?=$cvp['estadocivil'];?><br />
    <strong>Data de nascimento</strong>: <?=formataData($cvp['nascimento'], 'php');?><br />
    <strong>Pessoa (PcD)</strong>: <?=$cvp['pcd'];?><br />
    <strong>Tipo de deficiência</strong>: <?=$cvp['tipopcd'];?><br />
    <strong>Filhos</strong>: <?=$cvp['filhos'];?> | <strong>Quantos filhos</strong>: <?=$cvp['qtyfilhos'];?><br />
    <strong>CEP</strong>: <?=$cvp['cep'];?><br />
    <strong>Endereço</strong>: <?=$cvp['endereco'];?>, número <?=$cvp['numero'];?>, <?=$cvp['complemento'];?>, <?=$cvp['bairro'];?> - <?=$cvp['cidade'];?>/<?=$cvp['uf'];?><br />
    <strong>Telefone residencial</strong>: <?=$cvp['tel_res'];?> |  <strong>Telefone celular</strong>: <?=$cvp['tel_cel'];?> | <strong>Telefone comercial</strong>: <?=$cvp['tel_com'];?><br />
    <strong>Recados</strong>: <?=$cvp['aoscuidados'];?><br />
    <strong>Naturalidade</strong>: <?=$cvp['naturalidade'];?><br />
    <strong>Nacionalidade</strong>: <?=$cvp['nacionalidade'];?><br />
    <strong>Mãe</strong>: <?=$cvp['mae'];?><br />
    <? if($cvp['pai']){?>
    	<strong>Pai</strong>: <?=$cvp['pai'];?><br />
    <? } ?>

    <!-- DOCUMENTOS -->
    <h3 class="titCv">Documentos</h3>
	<strong>RG</strong>: <?=$cvd['rg'];?> | <strong>Emissor</strong>: <?=$cvd['emissor'];?> | <strong>UF</strong>: <?=$cvd['uf'];?><br />
    <strong>CPF</strong>: <?=$cvd['cpf'];?><br />
    <strong>CNH</strong>: <?=$cvd['cnh'];?> | <strong>Categoria</strong>: <?=$cvd['categoria'];?><br />
    <strong>CTPS</strong>: <?=$cvd['ctps'];?> - <strong>Série:</strong> <?=$cvd['serie'];?><br />
    <strong>PIS/PASEP</strong>: <?=$cvd['pispasep'];?><br />
    <strong>Reservista</strong>: <?=$cvd['reservista'];?><br />

    <!-- FORMAÇÃO -->
    <? if($cv3->rowCount() > 0){ ?>
    <h3 class="titCv">Formação</h3>
	<? while($cvf = $cv3->fetch(PDO::FETCH_ASSOC)){?>
    <strong>Instituição</strong>: <?=$cvf['instituicao'];?><br />
    <strong>Nome curso</strong>: <?=$cvf['nome_curso'];?><br />
    <strong>Status</strong>: <?=$cvf['status'];?><br /> 
    <strong>Conclusão</strong>: <?=$cvf['conclusao'];?><br /><br />
    <? } }?>

    <!-- INFO ADICIONAIS -->
    <h3 class="titCv">Informações Adicionais</h3>
    <strong>Disponibilidade para trabalho aos finais de semana e feriados</strong>: <?=$cva['disp_trabalho'];?><br />
    <strong>Disponibilidade para viagens</strong>: <?=$cva['disp_viagem'];?><br />
    <strong>Possui veículo</strong>: <?=$cva['veiculo'];?><br />
    <strong>Trabalha no Estado</strong>: <?=$cva['trabalha_estado'];?><br />
    <strong>Orgão que trabalha</strong>: <?=$cva['trabalha_estado_orgao'];?><br />
    <strong>Trabalhou no Estado</strong>: <?=$cva['trabalhou_estado'];?><br />
    <strong>Orgão que trabalhou</strong>: <?=$cva['trabalhou_estado_orgao'];?><br />
    <strong>Local</strong>: <?=$cva['trabalhou_estado_local'];?><br />
    <strong>Tipo contratação</strong>: <?=$cva['trabalhou_estado_contratacao'];?> | <strong>Há quanto tempo</strong>: <?=$cva['trabalhou_estado_tempo'];?><br />
    <strong>Possui parente no Instituto</strong>: <?=$cva['parente'];?><br />
    <strong>Área de atuação</strong>: <?=$cva['parente_area'];?><br />
    <strong>Nome do parente</strong>: <?=$cva['parente_nome'];?><br />
    <strong>Grau de parentesco</strong>: <?=$cva['parente_grau'];?><br />

    <!-- EXPERIÊNCIA PROFISSIONAL -->
    <? if($cv5->rowCount() > 0){ ?>
	    <h3 class="titCv">Experiência Profissional</h3>
		<? while($cve = $cv5->fetch(PDO::FETCH_ASSOC)){?>
	    <strong>Nome empresa</strong>: <?=$cve['nome_empresa'];?><br />
		<strong>Cidade</strong>: <?=$cve['cidade'];?><br />
		<strong>Telefone</strong>: <?=$cve['telefone'];?><br />
		<strong>Cargo</strong>: <?=$cve['cargo'];?><br />
		<strong>Início</strong>: <?=formataData($cve['inicio'], 'php');?><br />
		<strong>Saída</strong>:  <?=formataData($cve['termino'], 'php');?><br />
		<strong>Atividades exercidas</strong>: <?=$cve['atividades'];?><br />
		<strong>Remuneração</strong>: <?=$cve['remuneracao'];?><br />
		<strong>Motivo da saída</strong>: <?=$cve['motivo_saida'];?><br />
		<strong>Referência</strong>: <?=$cve['ref_nome'];?><br />
		<strong>Telefone referência</strong>: <?=$cve['ref_tel'];?><br /><br />
	<? } }?>

    <!-- CAPACITAÇÃO PROFISSIONAL -->
	<? if($cv6->rowCount() > 0){ ?>
	    <h3 class="titCv">Capacitação Profissional</h3>
	   	<? while($cvc = $cv6->fetch(PDO::FETCH_ASSOC)){?>
	    <strong>Curso</strong>: <?=$cvc['curso']?><br />
	    <strong>Instituição</strong>: <?=$cvc['instituicao']?><br />
	    <strong>Conclusão</strong>: <?=formataData($cvc['conclusao'], 'php');?><br /><br />
    <? }}?>

	<!-- INFO EXTRA -->
    <h3 class="titCv">Informação extra</h3>
	<strong>Como soube da vaga</strong>: <?=$cvx['sobreavaga'];?><br />
    <? if($cvx['comentarios']){?><strong>Comentários</strong>: <?=$cvx['comentarios'];?><br /><? } ?>

    <!-- CANDIDATURAS -->
    <h3 class="titCv">Candidaturas</h3>
    Candidato inscrito em <?=$cv8->rowCount();?> vaga(s)<br />
    <? while($cvv = $cv8->fetch(PDO::FETCH_ASSOC)){
        echo "Se inscreveu na vaga <b>".$cvv['numVg']."</b>, do edital <b>".$cvv['numEdital']."</b> na data: <b>".formataDataHora2($cvv['datainscricao'], 'php')."</b><br>";
    }?>

    <!-- ASSINATURA -->
    <div style="clear:both; height: 40px"></div>
    
    <div id="cxDeclaro">
        <input type="checkbox" id="declaro" name="checkbox" />
        <label for="declaro">Declaro que as informações acima prestadas são verdadeiras, e assumo a inteira responsabilidade pelas mesmas.</label>
    </div>
    
    <br><br><br><br>
    <div style="border-top:1px solid #000; width:50%; margin: 20px 0 0 0">
         Assinatura do candidato
    </div>


    <!-- AÇÕES -->
    <button class="btn btn-danger btnPrintCv"  onclick="imprime()" style="margin: 30px 0">Clique para imprimir seu currículo <span class="glyphicon glyphicon-print"></span></button>
</div>


</body>
</html>