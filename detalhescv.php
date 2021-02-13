<? 
$acaolocal = 'detalhesCV';
include('ctrl/ctrlSite.php');

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
	<div class="row">
		<h1 class="text-center">Detalhes do currículo</h1>
	</div>

    <div class="row">
		<div class="avisoCV vc fw6 <?=$classecv;?>"><?=$avisoCV;?></div>
    </div>

    <div class="row">
        <div id="rootwizard2">
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
					<strong>Nome</strong>: <?=$cv2['nome'];?><br />
                    <strong>E-mail</strong>: <?=$cv['email'];?><br />
                    <strong>Gênero</strong>: <?=$cv2['genero'];?><br />
                    <strong>Estado Civil</strong>: <?=$cv2['estadocivil'];?><br />
                    <strong>Data de nascimento</strong>: <?=formataData($cv2['nascimento'], 'php');?><br />
                    <strong>Pessoa (PcD)</strong>: <?=$cv2['pcd'];?><br />
                    <strong>Tipo de deficiência</strong>: <?=$cv2['tipopcd'];?><br />
                    <strong>Filhos</strong>: <?=$cv2['filhos'];?><br />
                    <strong>Quantos filhos</strong>: <?=$cv2['qtyfilhos'];?><br />
                    <strong>CEP</strong>: <?=$cv2['cep'];?><br />
                    <strong>Endereço</strong>: <?=$cv2['endereco'];?>, número <?=$cv2['numero'];?>, <?=$cv2['complemento'];?>, <?=$cv2['bairro'];?> - <?=$cv2['cidade'];?>/<?=$cv2['uf'];?><br />
                    <strong>Telefone residencial</strong>: <?=$cv2['tel_res'];?><br />
                    <strong>Telefone celular</strong>: <?=$cv2['tel_cel'];?><br />
                    <strong>Telefone comercial</strong>: <?=$cv2['tel_com'];?><br />
                    <strong>Recados</strong>: <?=$cv2['aoscuidados'];?><br />
                    <strong>Naturalidade</strong>: <?=$cv2['naturalidade'];?><br />
                    <strong>Nacionalidade</strong>: <?=$cv2['nacionalidade'];?><br />
                    <strong>Mãe</strong>: <?=$cv2['mae'];?><br />
                    <strong>Pai</strong>: <?=$cv2['pai'];?><br />
                </div>

                <div class="tab-pane" id="tab2">
					<strong>RG</strong>: <?=$cv3['rg'];?><br />
                    <strong>Emissor</strong>: <?=$cv3['emissor'];?><br />
                    <strong>UF</strong>: <?=$cv3['uf'];?><br />
                    <strong>CPF</strong>: <?=$cv3['cpf'];?><br />
                    <strong>CNH</strong>: <?=$cv3['cnh'];?><br />
                    <strong>Categoria</strong>: <?=$cv3['categoria'];?><br />
                    <strong>CTPS</strong>: <?=$cv3['ctps'];?> - Série: <?=$cv3['serie'];?><br />
                    <strong>PIS/PASEP</strong>: <?=$cv3['pispasep'];?><br />
                    <strong>Reservista</strong>: <?=$cv3['reservista'];?><br />
                    <strong>Conta Caixa</strong>: <?=$cv3['contacaixa'];?><br />
                </div>

                <div class="tab-pane" id="tab3">
					<? while($cv4 = $det4->fetch(PDO::FETCH_ASSOC)){?>
                    <strong>Instituição</strong>: <?=$cv4['instituicao'];?><br />
                    <strong>Nome curso</strong>: <?=$cv4['nome_curso'];?><br />
                    <strong>Status</strong>: <?=$cv4['status'];?><br /> 
                    <strong>Conclusão</strong>: <?=$cv4['conclusao'];?><br />
                    <hr />
                    <? } ?>
                </div>

                <div class="tab-pane" id="tab4">
                    <strong>Disponibilidade para trabalho aos finais de semana e feriados</strong>: <?=$cv5['disp_trabalho'];?><br />
                    <strong>Disponibilidade para viagens</strong>: <?=$cv5['disp_viagem'];?><br />
                    <strong>Possui veículo</strong>: <?=$cv5['veiculo'];?><br />
                    <strong>Trabalha no Estado</strong>: <?=$cv5['trabalha_estado'];?><br />
                    <strong>Orgão que trabalha</strong>: <?=$cv5['trabalha_estado_orgao'];?><br />
                    <strong>Trabalhou no Estado</strong>: <?=$cv5['trabalhou_estado'];?><br />
                    <strong>Orgão que trabalhou</strong>: <?=$cv5['trabalhou_estado_orgao'];?><br />
                    <strong>Local</strong>: <?=$cv5['trabalhou_estado_local'];?><br />
                    <strong>Tipo contratação</strong>: <?=$cv5['trabalhou_estado_contratacao'];?><br />
                    <strong>Há quanto temp</strong>o: <?=$cv5['trabalhou_estado_tempo'];?><br />
                    <strong>Possui parente no Instituto</strong>: <?=$cv5['parente'];?><br />
                    <strong>Área de atuação</strong>: <?=$cv5['parente_area'];?><br />
                    <strong>Nome do parente</strong>: <?=$cv5['parente_nome'];?><br />
                    <strong>Grau de parentesco</strong>: <?=$cv5['parente_grau'];?><br />
                </div>

                <div class="tab-pane" id="tab5">
					<? while($cv6 = $det6->fetch(PDO::FETCH_ASSOC)){?>
                    <strong>Nome empresa</strong>: <?=$cv6['nome_empresa'];?><br />
					<strong>Cidade</strong>: <?=$cv6['cidade'];?><br />
					<strong>Telefone</strong>: <?=$cv6['telefone'];?><br />
					<strong>Cargo</strong>: <?=$cv6['cargo'];?><br />
					<strong>Início</strong>: <?=formataData($cv6['inicio'], 'php');?><br />
					<strong>Saída</strong>:  <?=formataData($cv6['termino'], 'php');?><br />
					<strong>Atividades exercidas</strong>: <?=$cv6['atividades'];?><br />
					<strong>Remuneração</strong>: <?=$cv6['remuneracao'];?><br />
					<strong>Motivo da saída</strong>: <?=$cv6['motivo_saida'];?><br />
					<strong>Referência</strong>: <?=$cv6['ref_nome'];?><br />
					<strong>Telefone referência</strong>: <?=$cv6['ref_tel'];?><br />
                    
                    <hr />
					<? } ?>
                </div>

                <div class="tab-pane" id="tab6">
                	<? while($cv7 = $det7->fetch(PDO::FETCH_ASSOC)){?>
                        <strong>Curso</strong>: <?=$cv7['curso']?><br />
                        <strong>Instituição</strong>: <?=$cv7['instituicao']?><br />
                        <strong>Conclusão</strong>: <?=formataData($cv7['conclusao'], 'php');?><br />
                        <hr />
                    <? } ?>
                </div>

                <div class="tab-pane" id="tab7">
                    <strong>Como soube da vaga</strong>: <?=$cv8['sobreavaga'];?><br />
                    <strong>Comentários</strong>: <?=$cv8['comentarios'];?><br />
                </div>

                <ul class="pager wizard">
                    <li class="previous"><a href="#">Anterior</a></li>
                    <li class="next"><a href="#">Próxima</a></li>
                </ul>

            </div>
        </div>
	</div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>