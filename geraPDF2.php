<? $acaolocal = 'geraPdfCv';?>
<? include('ctrl/ctrlSite.php');
if(!isset($_SESSION)) session_start();
verificaLogado();
include('inc_header.php');
?>
<script src="../js/jspdf.min.js"></script>
<script src="../js/split_text_to_size.js"></script>
<body>
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

<? if($erro){?>
<div class="container">
	<div class="alert alert-danger"><?=$erro;?></div>
</div>
<? } else { ?>
	<script type="text/javascript">
	var img = 'data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABkAAD/4QMtaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTMyRjMxREJBMkUyMTFFN0I3MkZDRjkyNTU3NjlDNTEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTMyRjMxRENBMkUyMTFFN0I3MkZDRjkyNTU3NjlDNTEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MzJGMzFEOUEyRTIxMUU3QjcyRkNGOTI1NTc2OUM1MSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1MzJGMzFEQUEyRTIxMUU3QjcyRkNGOTI1NTc2OUM1MSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pv/uAA5BZG9iZQBkwAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEB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'
		var doc = new jsPDF()
		var pos = 30;

		doc.addImage(img, 'JPG', 170, 10, 25, 14)
		doc.setFontSize(16)
		doc.setFontType('bold')
		doc.text(10, 18,'Curriculum Vitae')
		doc.line(10, 20, 165, 20)

		/* DADOS PESSOAIS */
		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.text(10, 30, '1) Dados pessoais')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)
		doc.setFontType('bold')
		doc.text(17, 40, 'Nome:')
		doc.setFontType('normal')
		doc.text(30, 40, '<?php echo $cvp['nome'];?>')

		doc.setFontType('bold')
		doc.text(17, 45, 'Email:')
		doc.setFontType('normal')
		doc.text(30, 45, '<?php echo $cvm['email'];?>')

		doc.setFontType('bold')
		doc.text(17, 50, 'Gênero:')
		doc.setFontType('normal')
		doc.text(33, 50, '<?php echo $cvp['genero'];?>')

		doc.setFontType('bold')
		doc.text(17, 55, 'Estado civil:')
		doc.setFontType('normal')
		doc.text(41, 55, '<?php echo $cvp['estadocivil'];?>')

		doc.setFontType('bold')
		doc.text(17, 60, 'Data de nascimento:')
		doc.setFontType('normal')
		doc.text(56, 60, '<?php echo formataData($cvp['nascimento'],"php");?>')

		doc.setFontType('bold')
		doc.text(17, 65, 'Pessoa (PcD):')
		doc.setFontType('normal')
		doc.text(44, 65, '<?php echo $cvp['pcd'];?>')


		doc.setFontType('bold')
		doc.text(54, 65, '|   CID:')
		doc.setFontType('normal')
		doc.text(67, 65, '<?php echo $cvp['cid'];?>')
		doc.setFontType('bold')
		doc.text(17, 70, 'Tipo de deficiência:')
		doc.setFontType('normal')

		//divide o tamanho do tipopcd caso seja maior que 140
		var splitTitle = doc.splitTextToSize('<?php echo $cvp['tipopcd'];?>', 140)
		//tamanho do array com o texto dividido, cada array será uma linha
		var sptLen = splitTitle.length;
		//variáveis de posicionamento das linhas
		var x = 55; var y = 70;

		for(var t = 0; t<sptLen; t++){
			if(t > 0){ x = 17; y = y+5;}
			doc.text(x, y, splitTitle[t])	
		}

		doc.setFontType('bold')
		doc.text(17,80, 'Tem filhos? ')
		doc.setFontType('normal')
		doc.text(40,80, '<?php echo $cvp['filhos'];?>')
		
		doc.setFontType('bold')
		doc.text(50,80, '|   Quantos? ')
		doc.setFontType('normal')
		doc.text(75,80, '<?php echo $cvp['qtyfilhos'];?>')

		doc.setFontType('bold')
		doc.text(17, 85, 'Endereço: ')
		doc.setFontType('normal')
		doc.text(37, 85, '<?php echo $cvp['endereco'];?>')

		doc.setFontType('bold')
		doc.text(17, 90, 'Número: ')
		doc.setFontType('normal')
		doc.text(35, 90, '<?php echo $cvp['numero'];?>')

		doc.setFontType('bold')
		doc.text(60, 90, 'Complemento: ')
		doc.setFontType('normal')
		doc.text(90, 90, '<?php echo $cvp['complemento'];?>')

		doc.setFontType('bold')
		doc.text(17, 95, 'CEP: ')
		doc.setFontType('normal')
		doc.text(28, 95, '<?php echo $cvp['cep'];?>')

		doc.setFontType('bold')
		doc.text(50, 95, 'Bairro: ')
		doc.setFontType('normal')
		doc.text(65, 95, '<?php echo $cvp['bairro'];?>')

		<?php $ce = $cvp['cidade'].'/'.$cvp['uf'];?>
		doc.setFontType('bold')
		doc.text(17, 100, 'Cidade/UF: ')
		doc.setFontType('normal')
		doc.text(40, 100, '<?php echo $ce;?>')

		doc.setFontType('bold')
		doc.text(17, 105, 'Tel. residencial: ')
		doc.setFontType('normal')
		doc.text(47, 105, '<?php echo $cvp['tel_res'];?>')

		doc.setFontType('bold')
		doc.text(73, 105, 'Tel. comercial: ')
		doc.setFontType('normal')
		doc.text(101, 105, '<?php echo $cvp['tel_com'];?>')

		doc.setFontType('bold')
		doc.text(127, 105, 'Tel. celular: ')
		doc.setFontType('normal')
		doc.text(150, 105, '<?php echo $cvp['tel_cel'];?>')

		doc.setFontType('bold')
		doc.text(17, 110, 'Recados aos cuidados de:')
		doc.setFontType('normal')
		doc.text(67, 110, '<?php echo $cvp['aoscuidados'];?>')

		doc.setFontType('bold')
		doc.text(17, 115, 'Naturalidade: ')
		doc.setFontType('normal')
		doc.text(44, 115, '<?php echo $cvp['naturalidade'];?>')

		doc.setFontType('bold')
		doc.text(17, 120, 'Nacionalidade: ')
		doc.setFontType('normal')
		doc.text(48, 120, '<?php echo $cvp['nacionalidade'];?>')

		doc.setFontType('bold')
		doc.text(17, 125, 'Nome do pai: ')
		doc.setFontType('normal')
		doc.text(44, 125, '<?php echo $cvp['pai'];?>')

		doc.setFontType('bold')
		doc.text(17, 130, 'Nome da mãe: ')
		doc.setFontType('normal')
		doc.text(46, 130, '<?php echo addslashes($cvp['mae']);?>')

		/* DOCUMENTAÇÃO */
		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.setFontType('bold')
		doc.text(10, 140, '2) Documentos')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)
		
		doc.text(17, 150, 'RG:')
		doc.setFontType('normal')
		doc.text(26, 150, '<?php echo $cvd['rg'];?>')

		doc.setFontType('bold')
		doc.text(45, 150, '|   Emissor:')
		doc.setFontType('normal')
		doc.text(67,150, '<?php echo $cvd['emissor'];?>')

		doc.setFontType('bold')
		doc.text(78, 150, '|   UF:')
		doc.setFontType('normal')
		doc.text(90,150, '<?php echo $cvd['uf'];?>')

		doc.setFontType('bold')
		doc.text(17, 155, 'CPF:')
		doc.setFontType('normal')
		doc.text(27, 155, '<?php echo $cvd['cpf'];?>')
		
		doc.setFontType('bold')
		doc.text(55, 155, '|   CNH:')
		doc.setFontType('normal')
		doc.text(75, 155, '<?php echo $cvd['cnh'];?>')

		doc.setFontType('bold')
		doc.text(105, 155, '|   Categoria:')
		doc.setFontType('normal')
		doc.text(130, 155, '<?php echo $cvd['categoria'];?>')

		doc.setFontType('bold')
		doc.text(17, 160, 'CPTS:')
		doc.setFontType('normal')
		doc.text(30, 160, '<?php echo $cvd['ctps'];?>')

		doc.setFontType('bold')
		doc.text(55, 160, '|   Série:')
		doc.setFontType('normal')
		doc.text(71, 160, '<?php echo $cvd['serie'];?>')
		
		doc.setFontType('bold')
		doc.text(95, 160, '|   PIS/PASEP:')
		doc.setFontType('normal')
		doc.text(125, 160, '<?php echo $cvd['pispasep'];?>')

		doc.setFontType('bold')
		doc.text(17, 165, 'Certificado de reservista:')
		doc.setFontType('normal')
		doc.text(65, 165, '<?php echo $cvd['reservista'];?>')

		doc.setFontType('bold')
		doc.text(17, 170, 'Possui conta na caixa?')
		doc.setFontType('normal')
		doc.text(62, 170, '<?php echo $cvd['contacaixa'];?>')


		/* FORMAÇÃO ACADÊMICA */
		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.setFontType('bold')
		doc.text(10, 180, '3) Formação acadêmica')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)
		
		<?php
		$c=0;
		while($cvf = $cv3 ->fetch(PDO::FETCH_ASSOC)){
		
		if($c > 0){?>
			var lMargin = 30;
		<? } else{?>
			var lMargin = 0;
		<? } ?>
		
		doc.setFontType('bold')
		doc.text(17, 190+lMargin, 'Instituição:')
		doc.setFontType('normal')
		doc.text(40, 190+lMargin, '<?php echo $cvf['instituicao'];?>')
		
		doc.setFontType('bold')
		doc.text(17, 195+lMargin, 'Nome do curso:')
		doc.setFontType('normal')
		doc.setFontSize(10)
		doc.text(50, 195+lMargin, '<?php echo $cvf['nome_curso'];?>')

		doc.setFontSize(11)
		doc.setFontType('bold')
		doc.text(17, 200+lMargin, 'Status:')
		doc.setFontType('normal')
		doc.text(33, 200+lMargin, '<?php echo $cvf['status'];?>')

		doc.setFontType('bold')
		doc.text(17, 205+lMargin, 'Conclusão:')
		doc.setFontType('normal')
		doc.text(40, 205+lMargin, '<?php echo $cvf['conclusao'];?>')

		doc.setFontType('bold')
		doc.text(17, 210+lMargin, 'Tipo da graduação:')
		doc.setFontType('normal')
		doc.text(55, 210+lMargin, '<?php echo $cvf['tipograduacao'];?>')
		
		<?php $c++; } ?>

		//Cria nova página
		doc.addPage()

		/* INFORMAÇÕES ADICIONAIS */
		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.setFontType('bold')
		doc.text(10, 19, '4) Informações Adicionais')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)
		
		doc.text(17, 30, 'Disponibilidade para trabalhar aos finais de semana e feriados?')
		doc.setFontType('normal')
		doc.text(135, 30, '<?php echo $cva['disp_trabalho'];?>')

		doc.setFontType('bold')
		doc.text(17, 35, 'Disponiblidade para viagens?')
		doc.setFontType('normal')
		doc.text(75, 35, '<?php echo $cva['disp_viagem'];?>')

		doc.setFontType('bold')
		doc.text(87, 35, '|   Possui veículo próprio?')
		doc.setFontType('normal')
		doc.text(137, 35, '<?php echo $cva['veiculo'];?>')

		doc.setFontType('bold')
		doc.text(17, 40, 'Trabalha no Estado?')
		doc.setFontType('normal')
		doc.text(58, 40, '<?php echo $cva['trabalha_estado'];?>')

		doc.setFontType('bold')
		doc.text(70, 40, '|   Em qual órgão?')
		doc.setFontType('normal')
		doc.text(106, 40, '<?php echo $cva['trabalha_estado_orgao'];?>')

		doc.setFontType('bold')
		doc.text(17, 45, 'Trabalhou no Estado?')
		doc.setFontType('normal')
		doc.text(61, 45, '<?php echo $cva['trabalhou_estado'];?>')

		doc.setFontType('bold')
		doc.text(72, 45, '|   Em qual órgão?')
		doc.setFontType('normal')
		doc.text(109, 45, '<?php echo $cva['trabalhou_estado_orgao'];?>')

		doc.setFontType('bold')
		doc.text(17, 50, 'Local:')
		doc.setFontType('normal')
		doc.text(30, 50, '<?php echo $cva['trabalhou_estado_local'];?>')

		doc.setFontType('bold')
		doc.text(17, 55, 'Tipo de contratação:')
		doc.setFontType('normal')
		doc.text(58, 55, '<?php echo $cva['trabalhou_estado_contratacao'];?>')

		doc.setFontType('bold')
		doc.text(17, 60, 'Há quanto tempo?')
		doc.setFontType('normal')
		doc.text(55, 60, '<?php echo $cva['trabalhou_estado_tempo'];?>')

		doc.setFontType('bold')
		doc.text(17, 65, 'Possui parentes ou afins no Instituto Reger?')
		doc.setFontType('normal')
		doc.text(104, 65, '<?php echo $cva['parente'];?>')

		doc.setFontType('bold')
		doc.text(17, 70, 'Qual área de atuação?')
		doc.setFontType('normal')
		doc.text(61, 70, '<?php echo $cva['parente_area'];?>')

		doc.setFontType('bold')
		doc.text(17, 75, 'Grau de parentesco:')
		doc.setFontType('normal')
		doc.text(59, 75, '<?php echo $cva['parente_grau'];?>')

		doc.setFontType('bold')
		doc.text(80, 75, 'Nome do parente:')
		doc.setFontType('normal')
		doc.text(115, 75, '<?php echo $cva['parente_nome'];?>')


		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.setFontType('bold')
		doc.text(10, 85, '5) Capacitação Profissional')
		doc.setFontType('normal')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)
		
		var tMargin = 1;
		<?php while($cvc = $cv6->fetch(PDO::FETCH_ASSOC)){?>
			doc.setFontType('bold')
			doc.text(17, 95+tMargin, 'Curso:')
			doc.setFontType('normal')
			doc.text(32, 95+tMargin, '<?php echo $cvc['curso'];?>')

			doc.setFontType('bold')
			doc.text(17, 100+tMargin, 'Instituição:')
			doc.setFontType('normal')
			doc.text(40, 100+tMargin, '<?php echo $cvc['instituicao'];?>')

			doc.setFontType('bold')
			doc.text(17, 105+tMargin, 'Conclusão:')
			doc.setFontType('normal')
			doc.text(40, 105+tMargin, '<?php echo formataData($cvc['conclusao'], "php");?>')
			tMargin = tMargin+18;
		<? } ?>


		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.setFontType('bold')
		doc.text(10, 100+tMargin, '6) Experiência profissional')
		doc.setFontType('normal')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)

		<? $a = 0;?>
		<?php while($cve = $cv5->fetch(PDO::FETCH_ASSOC)){?>
			<? if ($a == 1){?>
				tMargin = -90;
				doc.addPage()
			<? }?>
			doc.setFontType('bold')
			doc.text(17, 109+tMargin, 'Nome da empresa:')
			doc.setFontType('normal')
			doc.text(54, 109+tMargin, '<?php echo $cve['nome_empresa'];?>')

			doc.setFontType('bold')
			doc.text(17, 114+tMargin, 'Telefone:')
			doc.setFontType('normal')
			doc.text(38, 114+tMargin, '<?php echo $cve['telefone'];?>')

			doc.setFontType('bold')
			doc.text(66, 114+tMargin, 'Cidade:')
			doc.setFontType('normal')
			doc.text(83, 114+tMargin, '<?php echo $cve['cidade'];?>')

			doc.setFontType('bold')
			doc.text(17, 119+tMargin, 'Cargo:')
			doc.setFontType('normal')
			doc.text(32, 119+tMargin, '<?php echo $cve['cargo'];?>')
		
			doc.setFontType('bold')
			doc.text(17, 124+tMargin, 'Data de início:')
			doc.setFontType('normal')
			doc.text(46, 124+tMargin, '<?php echo formataData($cve['inicio'], "php");?>')

			doc.setFontType('bold')
			doc.text(70, 124+tMargin, ' |   Data de término:')
			doc.setFontType('normal')
			doc.text(109, 124+tMargin, '<?php echo formataData($cve['termino'], "php");?>')

			doc.setFontType('bold')
			doc.text(17, 129+tMargin, 'Atividades exercidas:')
			doc.setFontType('normal')
			doc.setFontSize(10)

			<? $atividades = str_replace('\"','\'', $cve['atividades']);?>
			<? $atividades = preg_replace( "/\r|\n/", "", $atividades );?>
			//divide o tamanho das atividades caso seja maior que 180
			var splitTitle2 = doc.splitTextToSize("<?php echo $atividades;?>", 180)
			//tamanho do array com o texto dividido, cada array será uma linha
			var sptLen = splitTitle2.length;
			//variáveis de posicionamento das linhas
			var x = 17; var y = 134+tMargin;
			
			for(var t = 0; t<sptLen; t++){
				if(t > 0){ x = 17; y = y+4;}
				doc.text(x, y, splitTitle2[t])	
			}
			tMargin = y-68;

			doc.setFontSize(11)
			doc.setFontType('bold')
			doc.text(17, 73+tMargin, 'Última remuneração:')
			doc.setFontType('normal')
			doc.text(60, 73+tMargin, '<?php echo $cve['remuneracao'];?>')

			doc.setFontType('bold')
			doc.text(17, 78+tMargin, 'Motivo da saída:')
			doc.setFontType('normal')
			doc.text(50, 78+tMargin, '<?php echo $cve['motivo_saida'];?>')

			doc.setFontType('bold')
			doc.text(17, 83+tMargin, 'Telefone:')
			doc.setFontType('normal')
			doc.text(35, 83+tMargin, '<?php echo $cve['ref_tel'];?>')

			doc.setFontType('bold')
			doc.text(60, 83+tMargin, 'Nome para referência:')
			doc.setFontType('normal')
			doc.text(105, 83+tMargin, '<?php echo $cve['ref_nome'];?>')
		<?php $a++;} ?>
		

		doc.setTextColor(200,15,20)
		doc.setFontSize(15)
		doc.setFontType('bold')
		doc.text(10, 92+tMargin, '7) Informações extra')
		doc.setTextColor(0,0,0)
		doc.setFontSize(11)

		doc.text(17,97+tMargin, 'Como você soube da vaga disponível?')
		doc.setFontType('normal')
		var splitTitle3 = doc.splitTextToSize("<?php echo $cvx['sobreavaga'];?>", 180)
		doc.text(17,102+tMargin, splitTitle3)

		doc.setFontType('bold')
		doc.text(17,107+tMargin, 'Comentários gerais')
		doc.setFontType('normal')
		var splitTitle4 = doc.splitTextToSize("<?php echo $cvx['comentarios'];?>", 180)
		doc.text(17,112+tMargin, splitTitle4)

		doc.save('cv.pdf')
	</script>
	<? } ?>
</body>
</html>