<? 

$acaolocal = 'buscaCV';
include('ctrl/ctrlSite.php');


verificaLogado();


include('inc_header.php');?>

<style type="text/css">

@media print {
	body * {
    visibility: hidden;
	}
	.cvInscritos, .cvInscritos * {
    visibility: visible;
	display:block;
	}
	.cvInscritos {
    position: absolute;
    left: 0;
    top: 0;
	z-index: 9999;
	}
	div{
     width:100%; height:30px

   }

	.tittr{width:100% !important; background:#CCC; color:#000 !important;}

}
</style>
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
	<div class="row">
		<h1 class="text-center">Detalhes do currículo</h1>
	</div>


    <div class="row">
    <div class="cvInscritos">
        <h3>Comprovantes enviados</h3>
        <?php
            if($dir_exists != false){
                foreach($files as $file){
                    if($file == "." || $file == "..")
                    continue;
                    echo '<a href="pdf/comprovante/'.$_REQUEST['idCV'].'/'.$file.'" target="_blank">'.$file.'</a><br>';
                }
            } else {
                echo "Não há comprovantes";
            }
        ?> 
		<h3>Informações pessoais</h3>
        
		<div>
        Candidato inscrito em <?=$cv8->rowCount();?> vaga(s)<br />
        <? 
		while($cvv = $cv8->fetch(PDO::FETCH_ASSOC)){
			echo "Se inscreveu na vaga <b>".$cvv['numVg']."</b>, do edital <b>".$cvv['numEdital']."</b> na data: <b>".formataDataHora2($cvv['datainscricao'], 'php')."</b><br>";

		}
        ?>
        <br /><br />
        Nome: <?=$cvp['nome'];?><br />
        E-mail: <?=$cvm['email'];?><br />
        Gênero: <?=$cvp['genero'];?><br />
        Estado Civil: <?=$cvp['estadocivil'];?><br />
        Data de nascimento: <?=formataData($cvp['nascimento'], 'php');?><br />
        Pessoa (PcD): <?=$cvp['pcd'];?><br />
        Tipo de deficiência: <?=$cvp['tipopcd'];?><br />
        CID: <?=$cvp['cid'];?><br />
        Filhos: <?=$cvp['filhos'];?><br />
        Quantos filhos: <?=$cvp['qtyfilhos'];?><br />
        CEP: <?=$cvp['cep'];?><br />
        Endereço: <?=$cvp['endereco'];?>, número <?=$cvp['numero'];?>, <?=$cvp['complemento'];?>, <?=$cvp['bairro'];?> - <?=$cvp['cidade'];?>/<?=$cvp['uf'];?><br />
        Telefone residencial: <?=$cvp['tel_res'];?><br />
        Telefone celular: <?=$cvp['tel_cel'];?><br />
        Telefone comercial: <?=$cvp['tel_com'];?><br />
        Recados: <?=$cvp['aoscuidados'];?><br />
        Naturalidade: <?=$cvp['naturalidade'];?><br />
        Nacionalidade: <?=$cvp['nacionalidade'];?><br />
        Mãe: <?=$cvp['mae'];?><br />
        Pai: <?=$cvp['pai'];?><br />
        
   		<h3>Documentos</h3>
		RG: <?=$cvd['rg'];?><br />
        Emissor: <?=$cvd['emissor'];?><br />
        UF: <?=$cvd['uf'];?><br />
        CPF: <?=$cvd['cpf'];?><br />
        CNH: <?=$cvd['cnh'];?><br />
        Categoria: <?=$cvd['categoria'];?><br />
        CTPS: <?=$cvd['ctps'];?> - Série: <?=$cvd['serie'];?><br />
        PIS/PASEP: <?=$cvd['pispasep'];?><br />
        Reservista: <?=$cvd['reservista'];?><br />
        Conta Caixa: <?=$cvd['contacaixa'];?><br />

   		<h3>Formação</h3>
		<? while($cvf = $cv3->fetch(PDO::FETCH_ASSOC)){?>
        Instituição: <?=$cvf['instituicao'];?><br />
        Nome curso: <?=$cvf['nome_curso'];?><br />
        Status: <?=$cvf['status'];?><br /> 
        Conclusão: <?=$cvf['conclusao'];?><br />
        <hr />
        <? } ?>
        
        <h3>Informações adicionais</h3>
        Disponibilidade para trabalho aos finais de semana e feriados: <?=$cva['disp_trabalho'];?><br />
        Disponibilidade para viagens: <?=$cva['disp_viagem'];?><br />
        Possui veículo: <?=$cva['veiculo'];?><br />
        Trabalha no Estado: <?=$cva['trabalha_estado'];?><br />
        Orgão que trabalha: <?=$cva['trabalha_estado_orgao'];?><br />
        Trabalhou no Estado: <?=$cva['trabalhou_estado'];?><br />
        Orgão que trabalhou: <?=$cva['trabalhou_estado_orgao'];?><br />
        Local: <?=$cva['trabalhou_estado_local'];?><br />
        Tipo contratação: <?=$cva['trabalhou_estado_contratacao'];?><br />
        Há quanto tempo: <?=$cva['trabalhou_estado_tempo'];?><br />
        Possui parente no Instituto: <?=$cva['parente'];?><br />
        Área de atuação: <?=$cva['parente_area'];?><br />
        Nome do parente: <?=$cva['parente_nome'];?><br />
        Grau de parentesco: <?=$cva['parente_grau'];?><br />
        
        <h3>Experiência</h3>
		<? while($cve = $cv5->fetch(PDO::FETCH_ASSOC)){?>
        Nome empresa: <?=$cve['nome_empresa'];?><br />
		Cidade: <?=$cve['cidade'];?><br />
		Telefone: <?=$cve['telefone'];?><br />
		Cargo: <?=$cve['cargo'];?><br />
		Início: <?=formataData($cve['inicio'], 'php');?><br />
		Saída:  <?=formataData($cve['termino'], 'php');?><br />
		Atividades exercidas: <?=$cve['atividades'];?><br />
		Remuneração: <?=$cve['remuneracao'];?><br />
		Motivo da saída: <?=$cve['motivo_saida'];?><br />
		Referência: <?=$cve['ref_nome'];?><br />
		Telefone referência: <?=$cve['ref_tel'];?><br />
        <hr />
		<? } ?>
        
        <h3>Capacitação profissional / Cursos</h3>
       	<? while($cvc = $cv6->fetch(PDO::FETCH_ASSOC)){?>
        Curso: <?=$cvc['curso']?><br />
        Instituição: <?=$cvc['instituicao']?><br />
        Conclusão: <?=formataData($cvc['conclusao'], 'php');?><br />
        <hr />
        <? } ?>
        
        <h3>Informações extras</h3>
        Como soube da vaga: <?=$cvx['sobreavaga'];?><br />
        Comentários: <?=$cvx['comentarios'];?><br />
		</div>
	</div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>