<?php

// define outra constante para configurar o path de upload de outros arquivos q não irão para o upload
define('REGER', $_SERVER['DOCUMENT_ROOT'].'/processoseletivo');

require_once ('class.PDO.php'); // chama classe que faz conexão ao mysql
require_once ('ctrlFunc.php'); // arquivo com funcoes, busca unidades, formata numeros, datas e por ai vai..

if(isset($_REQUEST['acao'])){
	$acao = $_REQUEST['acao']; //recupera a ação realizada
}

if(empty($acao)) $acao = $acaolocal; // obtém a acao caso tenha sido setada no arquivo e não na url

if(!isset($_SESSION['rgr'])) session_start();

switch($acao){
	case "login":
		$email = trim($_POST['usuario']);
		$senha = trim($_POST['senha']);

		if(!empty($email) && !empty($senha)){
			$pdo = Database::conexao();
			require_once ('PasswordHash.php');

			try{
				$stmt = $pdo->prepare('SELECT * FROM cv_usuarios WHERE email = ?');
				$stmt -> bindParam(1, $email, PDO::PARAM_STR);
				$stmt -> execute();
				$conta = $stmt->rowCount();

				if($conta == 1){
					$res = $stmt->fetch(PDO::FETCH_ASSOC);
					$hash = $res['senha'];

					$t_hasher = new PasswordHash(8, FALSE);
					$check = $t_hasher->CheckPassword($senha, $hash);

					if($check){
						if($res['cod_nivel'] == 999) echo "1";
						if($res['cod_nivel'] == 0) echo "2";

						if(!isset($_SESSION)){ session_start();} // se a sessão não existir, inicia.

						$_SESSION['rgr']['usuarioId']    = $res['id'];
						$_SESSION['rgr']['nivelUsuario'] = $res['cod_nivel'];
						$_SESSION['rgr']['emailUsuario'] = $res['email'];
					} else {
							echo 0;
						}
				}
			} // fim try
			catch(PDOException $e){
				echo $e->getMessage();
			} // fim catch
		} else {
			header("Location: index.php");
			exit;
		}
	break; // fim case

	case "deslogar":
		apagaSessao();
		header("Location: index.php");
	break;

	case "listaProcSe":
		$pdo = Database::conexao();
		$lis = $pdo->prepare('SELECT * FROM ps_vagas');
		$lis -> execute();
	break;

	case "inicialUsu":
		$pdo = Database::conexao();
		$status = 'Processo finalizado';

		$lisv = $pdo->prepare('SELECT * FROM ps_edital WHERE status != :status');
		$lisv -> bindValue(':status', $status);
		$lisv -> execute();
		$numPsAberto = $lisv->rowCount();


		$lis = $pdo->prepare('SELECT * FROM ps_edital WHERE status = :status');
		$lis -> bindValue(':status', $status);
		$lis -> execute();
	
		$numps = $lis->rowCount();

		$idusuario = $_SESSION['rgr']['usuarioId'];
		$pdo = Database::conexao();
		$cv = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :usuario');
		$cv -> bindValue(':usuario', $idusuario);
		$cv -> execute();
		$numcv = $cv->rowCount();
	

		if ($numcv == 0){
			$avisoCV = "Você ainda não cadastrou seu currículo. <a href='cadcv.php' class='fw7 vc'>Clique aqui</a> e cadastre seu currículo para se candidatar as vagas";
			$classecv = 'erro';
		}
	break;

	case "listavagas":
		$idEdital = $_REQUEST['idEdital'];
		$pdo = Database::conexao();
		$lis = $pdo->prepare('
			SELECT v.id as idVG, v.numero, v.cargo, v.atribuicoes, v.formacao, v.local, v.edital, e.id, e.nome 
			FROM ps_vagas v, ps_edital e
			WHERE v.edital = e.id AND v.edital = :idEdital 
			ORDER BY numero ASC');
		$lis->bindValue(':idEdital', $idEdital);
		$lis->execute();
	break;

	case "listaCandidatos":
		$idps = $_REQUEST['idPS'];

		$pdo = Database::conexao();
		$res2 = $pdo->prepare('SELECT v.numero, v.cargo, e.nome
			FROM ps_candidatos c, ps_vagas v, ps_edital e
			WHERE id_vaga = :idvg AND v.id = c.id_vaga AND e.id = v.edital');
		$res2 -> bindValue(':idvg',$idps);
		$res2->execute();
		$infoVaga = $res2->fetch(PDO::FETCH_ASSOC);

		/*$res = $pdo->prepare('
			SELECT c.id_vaga, c.id_usuario, p.nome, p.nascimento, f.nome_curso, d.cpf, COUNT(f.id_usuario) as qtyCursos
			FROM ps_candidatos c, cv_pessoais p, cv_formacao f, cv_documentos d
			WHERE c.id_vaga = :idvg AND c.id_usuario = p.id_usuario AND f.id_usuario = c.id_usuario AND d.id_usuario = c.id_usuario
			GROUP BY c.id_usuario');*/

		$res = $pdo->prepare('
			SELECT c.id_vaga, c.id_usuario, p.nome, p.nascimento, p.pcd, f.nome_curso, d.cpf, COUNT(f.id_usuario) as qtyCursos
			FROM ps_candidatos AS c
			LEFT JOIN cv_pessoais AS p ON c.id_usuario = p.id_usuario
			LEFT JOIN cv_formacao AS f ON c.id_usuario = f.id_usuario
			LEFT JOIN cv_documentos AS d ON c.id_usuario = d.id_usuario
			WHERE id_vaga = :idvg
			GROUP BY c.id_usuario');
		$res->bindValue(':idvg', $idps);
		$res->execute();
	break;

	case "listaCandidatos2":
		$idps = $_REQUEST['idPS'];
		$pdo = Database::conexao();

		// busca informações da vaga (numero edital e  numero da vaga)
		$vaga = $pdo->prepare('SELECT ps_vagas.numero as numVg, ps_vagas.edital, ps_edital.numero as numEdital FROM ps_vagas, ps_edital WHERE ps_vagas.id = :idvg AND ps_vagas.edital = ps_edital.id');
		$vaga -> bindValue(':idvg', $idps);
		$vaga -> execute();
		$ve = $vaga->fetch(PDO::FETCH_ASSOC);

		// informações do filtro
		if($_POST){
			$pcd = $_POST['pcd'];
			$formacao = $_POST['formacao'];
			$ordem = $_POST['ordem'];
			$ord = $_POST['ord'];

			$where = '';

			if(!empty($pcd)){      $where .= ' AND cv_pessoais.pcd = :pcd';}
			if(!empty($formacao)){ $where .= '  AND cv_formacao.nome_curso LIKE "%":formacao"%"';}
		}
			if(empty($ordem)){     $ordem  = 'datainscricao';}
			if(empty($ord)){       $ord    = 'ASC';}

		// busca informações dos inscritos da vaga
		$lis = $pdo->prepare('
			SELECT
				ps_candidatos.*, cv_pessoais.nome, cv_pessoais.nascimento, cv_formacao.id_usuario, cv_formacao.nome_curso
				FROM ps_candidatos
				JOIN cv_pessoais ON cv_pessoais.id_usuario = ps_candidatos.id_usuario
				JOIN cv_formacao ON cv_formacao.id_usuario = ps_candidatos.id_usuario
				WHERE ps_candidatos.id_vaga = :idvg '.$where.'
				GROUP BY cv_formacao.id_usuario
				ORDER BY '.$ordem.' '.$ord.'
		');

		$lis->bindValue(':idvg', $idps);
		if(!empty($pcd)){ $lis->bindValue(':pcd', $pcd);}
		if(!empty($formacao)){ $lis->bindValue(':formacao', $formacao);}
		$lis->execute();
	break;

  case "vinculaUV":
    $pdo = Database::conexao();

    //verifica se há dados preenchidos relacionados ao id do usuário
    $buscadet = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :idusuario LIMIT 1');
    $buscadet -> bindValue(':idusuario', $_POST['usuario']);
    $buscadet -> execute();

    if($buscadet->rowCount() > 0){
      
      $agora = date("Y-m-d");

      //verifica se o edital da vaga está dentro do período de inscrições
      $consv = $pdo->prepare('SELECT status FROM ps_edital WHERE id = :ide AND :date >= inicio AND :date <= termino');
      $consv -> bindValue(':ide', $_POST['edital']);
      $consv -> bindValue(':date', $agora);
      $consv -> execute();
      $stts = $consv -> fetch(PDO::FETCH_ASSOC);

      if($stts['status'] == 'Vigente'){
        // verifica se o candidato já está inscrito em um edital com status vigente
        $rel = $pdo->prepare('
                  SELECT ps_edital.id as idEdital, ps_edital.status, ps_vagas.id as idVaga, ps_vagas.edital, ps_candidatos.id_vaga, ps_candidatos.id_usuario 
                  FROM ps_edital, ps_candidatos, ps_vagas 
                  WHERE ps_candidatos.id_usuario = :idu
                  AND ps_candidatos.id_vaga = ps_vagas.id
                  AND ps_vagas.edital = ps_edital.id
                  AND ps_edital.status = :status
                ');
        $rel -> bindValue(':idu', $_POST['usuario']);
        $rel -> bindValue(':status', 'Vigente');
        $rel -> execute();


        if($rel->rowCount() == 0){
          $vin = $pdo->prepare('INSERT INTO ps_candidatos (id_vaga, id_usuario, datainscricao) VALUES(:idv, :idu, NOW())');
          $vin -> bindValue(':idv', $_POST['ps']);
          $vin -> bindValue(':idu', $_POST['usuario']);

          if($vin->execute()){
            echo json_encode(0); //codResult = 0 | Inscricao realizada
            envia_confirmacao_email($_POST['usuario'], $_POST['ps']); // envia confirmação de inscrição para o email do usuário
          }
        } else {// fim if rel->count
          echo json_encode(1);
        }
      } else {
        echo json_encode(2); // Período de inscricoes nao esta ativo
      }
    } else {
      echo json_encode(3);
    }
  break;

	case "novousuario":

		require_once ('PasswordHash.php');
		$phpass = new PasswordHash(8, FALSE);
		$hash = $phpass->HashPassword($_POST['novaSenha']);

		$pdo = Database::conexao();
		$cv = $pdo->prepare('SELECT * FROM cv_usuarios WHERE email = :email');
		$cv -> bindValue(':email', $_POST['novoEmail']);
		$cv->execute();

		if($cv->rowCount() > 0){
			$classer =  'erro';
			$avisor = 'O email já está cadastrado em nosso sistema!';
		} else {
			$cv3 = $pdo->prepare('INSERT INTO cv_usuarios (email, senha, cod_nivel) VALUES(:email, :senha, :cod)');
			$cv3->bindValue(':email', $_POST['novoEmail']);
			$cv3->bindValue(':senha', $hash);
			$cv3->bindValue(':cod', 0);
			
			if($cv3->execute()){
				
				//$id = $pdo->lastInsertId();
				$bid = $pdo->prepare('SELECT * FROM cv_usuarios WHERE email = :email');
				$bid ->bindValue(':email', $_POST['novoEmail']);

				if($bid ->execute()){
					$r = $bid->fetch(PDO::FETCH_ASSOC);
					$id = $r['id'];
				}

				$_SESSION['rgr']['usuarioId']    = $id;
				$_SESSION['rgr']['nivelUsuario'] = '0';
				$_SESSION['rgr']['emailUsuario'] = $_POST['novoEmail'];

				echo '<script type="text/javascript">
				window.location = "cadcv.php"
				</script>';
				//header('Location:cadcv.php');
			}
		}
	break;

	case "cadCv":
	/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/
		$pdo = Database::conexao();
		$cv2 = $pdo->prepare('SELECT cpf FROM cv_documentos WHERE cpf = :cpf');
		$cv2 -> bindValue(':cpf', $_POST['cpf']);
		$cv2 -> execute();

		if($cv2->rowCount() > 0){
			$avisoCV = 'Já existe um cadastro com o CPF informado';
			$classecv = 'erro';
		} else {
			if(!isset($_SESSION)) session_start();
			$idusuario = $_SESSION['rgr']['usuarioId'];

			$cvp = $pdo->prepare('INSERT INTO cv_pessoais (id_usuario, nome, genero, estadocivil, nascimento, pcd, tipopcd, cid, filhos, qtyfilhos, endereco, numero, complemento, cep, bairro, cidade, uf, tel_res, tel_cel, tel_com, aoscuidados, naturalidade, nacionalidade, mae, pai) VALUES (:id, :nome, :genero, :estadocivil, :nascimento, :pcd, :tipopcd, :cid, :filhos, :qtyfilhos, :endereco, :numero, :complemento, :cep, :bairro, :cidade, :uf, :tel_res, :tel_cel, :tel_com, :aoscuidados, :naturalidade, :nacionalidade, :mae, :pai )');

			$cvp->bindValue(':id', $idusuario);
			$cvp->bindValue(':nome', $_POST['nome']);
			$cvp->bindValue(':genero', $_POST['genero']);
			$cvp->bindValue(':estadocivil', $_POST['estadocivil']);
			$cvp->bindValue(':nascimento', formataData($_POST['nascimento'], 'mysql'));
			$cvp->bindValue(':pcd', $_POST['pcd']);
			$cvp->bindValue(':tipopcd', $_POST['deficiencia']);
			$cvp->bindValue(':cid', $_POST['cid']);
			$cvp->bindValue(':filhos', $_POST['filhos']);
			$cvp->bindValue(':qtyfilhos', $_POST['qtyfilhos']);
			$cvp->bindValue(':endereco', $_POST['rua']);
			$cvp->bindValue(':numero', $_POST['numero']);
			$cvp->bindValue(':complemento', $_POST['complemento']);
			$cvp->bindValue(':cep', $_POST['cep']);
			$cvp->bindValue(':bairro', $_POST['bairro']);
			$cvp->bindValue(':cidade', $_POST['cidade']);
			$cvp->bindValue(':uf', $_POST['uf']);
			$cvp->bindValue(':tel_res', $_POST['tel_res']);				
			$cvp->bindValue(':tel_cel', $_POST['tel_cel']);
			$cvp->bindValue(':tel_com', $_POST['tel_com']);
			$cvp->bindValue(':aoscuidados', $_POST['recados']);
			$cvp->bindValue(':naturalidade', $_POST['naturalidade']);
			$cvp->bindValue(':nacionalidade', $_POST['nacionalidade']);
			$cvp->bindValue(':mae', $_POST['mae']);
			$cvp->bindValue(':pai', $_POST['pai']);
			$cvp->execute();

			$cvd = $pdo->prepare('INSERT INTO cv_documentos (id_usuario, rg, emissor, uf, cpf, cnh, categoria, ctps, serie, pispasep, reservista, contacaixa) VALUES(:id2, :rg, :emissor, :uf, :cpf, :cnh, :categoria, :ctps, :serie, :pispasep, :reservista, :contacaixa)');

			$cvd -> bindValue(':id2', $idusuario);
			$cvd -> bindValue(':rg', $_POST['rg']);
			$cvd -> bindValue(':emissor', $_POST['emissor']);
			$cvd -> bindValue(':uf', $_POST['uf']);
			$cvd -> bindValue(':cpf', $_POST['cpf']);
			$cvd -> bindValue(':cnh', $_POST['cnh']);
			$cvd -> bindValue(':categoria', $_POST['categoria']);
			$cvd -> bindValue(':ctps', $_POST['ctps']);
			$cvd -> bindValue(':serie', $_POST['serie']);
			$cvd -> bindValue(':pispasep', $_POST['pispasep']);
			$cvd -> bindValue(':reservista', $_POST['reservista']);
			$cvd -> bindValue(':contacaixa', $_POST['conta']);
			$cvd -> execute();

			if(!empty($_POST['instituicao']) || !empty($_POST['curso']) || !empty($_POST['status']) || !empty($_POST['conclusao'])){
				$cvf = $pdo->prepare('INSERT INTO cv_formacao (id_usuario, instituicao, nome_curso, status, conclusao, tipograduacao) VALUES(:id, :instituicao, :nome_curso, :status, :conclusao, :tipograduacao)');

				$cvf -> bindValue(':id', $idusuario);
				$cvf -> bindValue(':instituicao', $_POST['instituicao']);
				$cvf -> bindValue(':nome_curso', $_POST['curso']);
				$cvf -> bindValue(':status', $_POST['status']);
				$cvf -> bindValue(':conclusao', $_POST['conclusao']);
				$cvf -> bindValue(':tipograduacao', $_POST['tipoGrad1']);
				$cvf->execute();
			}

			if(!empty($_POST['instituicao2']) || !empty($_POST['curso2']) || !empty($_POST['status2']) || !empty($_POST['conclusao2'])){
				$cvf2 = $pdo->prepare('INSERT INTO cv_formacao (id_usuario, instituicao, nome_curso, status, conclusao, tipograduacao) VALUES(:id, :instituicao2, :nome_curso2, :status2, :conclusao2, :tipograduacao2)');
				$cvf2 -> bindValue(':id', $idusuario);
				$cvf2 -> bindValue(':instituicao2', $_POST['instituicao2']);
				$cvf2 -> bindValue(':nome_curso2', $_POST['curso2']);
				$cvf2 -> bindValue(':status2', $_POST['status2']);
				$cvf2 -> bindValue(':conclusao2', $_POST['conclusao2']);
				$cvf2 -> bindValue(':tipograduacao2', $_POST['tipoGrad2']);
				$cvf2->execute();
			}

			$cva = $pdo->prepare('INSERT INTO cv_adicionais (id_usuario, disp_trabalho, disp_viagem, veiculo, trabalha_estado, trabalha_estado_orgao, trabalhou_estado, trabalhou_estado_orgao, trabalhou_estado_local, trabalhou_estado_contratacao, trabalhou_estado_tempo, parente, parente_area, parente_grau, parente_nome) VALUES(:id, :disp_trabalho, :disp_viagem, :veiculo, :trabalha_estado, :trabalha_estado_orgao, :trabalhou_estado, :trabalhou_estado_orgao, :trabalhou_estado_local, :trabalhou_estado_contratacao, :trabalhou_estado_tempo, :parente, :parente_area, :parente_grau, :parente_nome)');

			$cva->bindValue(':id', $idusuario);
			$cva->bindValue(':disp_trabalho', $_POST['fds']);
			$cva->bindValue(':disp_viagem', $_POST['viagens']);
			$cva->bindValue(':veiculo', $_POST['veiculo']);
			$cva->bindValue(':trabalha_estado', $_POST['trabalha_estado']);
			$cva->bindValue(':trabalha_estado_orgao', $_POST['orgaotrabalha']);
			$cva->bindValue(':trabalhou_estado', $_POST['trabalhou_estado']);
			$cva->bindValue(':trabalhou_estado_orgao', $_POST['orgaotrabalhou']);
			$cva->bindValue(':trabalhou_estado_local', $_POST['local']);
			$cva->bindValue(':trabalhou_estado_contratacao', $_POST['tipocontratacao']);
			$cva->bindValue(':trabalhou_estado_tempo', $_POST['qtotempo']);
			$cva->bindValue(':parente', $_POST['parentes']);
			$cva->bindValue(':parente_area', $_POST['atuacao']);
			$cva->bindValue(':parente_grau', $_POST['grau']);
			$cva->bindValue(':parente_nome', $_POST['nomeparente']);
			$cva->execute();

			if(!empty($_POST['nomeempresa']) || !empty($_POST['cidadeempresa']) || !empty($_POST['telempresa']) || !empty($_POST['cargoempresa']) || !empty($_POST['datainicio1']) || !empty($_POST['datasaida1']) || !empty($_POST['atividades']) || !empty($_POST['ultimaremuneracao']) || !empty($_POST['motivosaida']) || !empty($_POST['referencia']) || !empty($_POST['telref'])){

				$cve = $pdo->prepare('INSERT INTO cv_experiencia (id_usuario, nome_empresa, cidade, telefone, cargo, inicio, termino, atividades, remuneracao, motivo_saida, ref_nome, ref_tel) VALUES (:id, :nome_empresa, :cidade, :telefone, :cargo, :inicio, :termino, :atividades, :remuneracao, :motivo_saida, :ref_nome, :ref_tel)');

				$cve -> bindValue(':id', $idusuario);
				$cve -> bindValue(':nome_empresa', $_POST['nomeempresa']);
				$cve -> bindValue(':cidade', $_POST['cidadeempresa']);
				$cve -> bindValue(':telefone', $_POST['telempresa']);
				$cve -> bindValue(':cargo', $_POST['cargoempresa']);
				$cve -> bindValue(':inicio', formataData($_POST['datainicio1'], 'mysql'));
				$cve -> bindValue(':termino', formataData($_POST['datasaida1'], 'mysql'));
				$cve -> bindValue(':atividades', $_POST['atividades']);
				$cve -> bindValue(':remuneracao', $_POST['ultimaremuneracao']);
				$cve -> bindValue(':motivo_saida', $_POST['motivosaida']);
				$cve -> bindValue(':ref_nome', $_POST['referencia']);
				$cve -> bindValue(':ref_tel', $_POST['telref']);
				$cve->execute();
			}

			if(!empty($_POST['nomeempresa2']) || !empty($_POST['cidadeempresa2']) || !empty($_POST['telempresa2']) || !empty($_POST['cargoempresa2']) || !empty($_POST['datainicio2']) || !empty($_POST['datasaida2']) || !empty($_POST['atividades2']) || !empty($_POST['ultimaremuneracao2']) || !empty($_POST['motivosaida2']) || !empty($_POST['referencia2']) || !empty($_POST['telref2'])){

				$cve2 = $pdo->prepare('INSERT INTO cv_experiencia (id_usuario, nome_empresa, cidade, telefone, cargo, inicio, termino, atividades, remuneracao, motivo_saida, ref_nome, ref_tel) VALUES (:id, :nome_empresa2, :cidade2, :telefone2, :cargo2, :inicio2, :termino2, :atividades2, :remuneracao2, :motivo_saida2, :ref_nome2, :ref_tel2)');

				$cve2 -> bindValue(':id', $idusuario);
				$cve2 -> bindValue(':nome_empresa2', $_POST['nomeempresa2']);
				$cve2 -> bindValue(':cidade2', $_POST['cidadeempresa2']);
				$cve2 -> bindValue(':telefone2', $_POST['telempresa2']);
				$cve2 -> bindValue(':cargo2', $_POST['cargoempresa2']);
				$cve2 -> bindValue(':inicio2', formataData($_POST['datainicio2'], 'mysql'));
				$cve2 -> bindValue(':termino2', formataData($_POST['datasaida2'], 'mysql'));
				$cve2 -> bindValue(':atividades2', $_POST['atividades2']);
				$cve2 -> bindValue(':remuneracao2', $_POST['ultimaremuneracao2']);
				$cve2 -> bindValue(':motivo_saida2', $_POST['motivosaida2']);
				$cve2 -> bindValue(':ref_nome2', $_POST['referencia2']);
				$cve2 -> bindValue(':ref_tel2', $_POST['telref2']);
				$cve2->execute();
			}

			if(!empty($_POST['cursoextra1']) || !empty($_POST['instextra1']) || !empty($_POST['dataconcextra1'])){
				$cvc = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso, :instituicao, :conclusao)');
				$cvc->bindValue(':id', $idusuario);
				$cvc->bindValue(':curso', $_POST['cursoextra1']);
				$cvc->bindValue(':instituicao', $_POST['instextra1']);
				$cvc->bindValue(':conclusao', formataData($_POST['dataconcextra1'], 'mysql'));
				$cvc->execute();
			}

			if(!empty($_POST['cursoextra2']) || !empty($_POST['instextra2']) || !empty($_POST['dataconcextra2'])){

				$cvc2 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso2, :instituicao2, :conclusao2)');
				$cvc2->bindValue(':id', $idusuario);
				$cvc2->bindValue(':curso2', $_POST['cursoextra2']);
				$cvc2->bindValue(':instituicao2', $_POST['instextra2']);
				$cvc2->bindValue(':conclusao2', formataData($_POST['dataconcextra2'], 'mysql'));
				$cvc2->execute();
			}

			if(!empty($_POST['cursoextra3']) || !empty($_POST['instextra3']) || !empty($_POST['dataconcextra3'])){
				$cvc3 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso3, :instituicao3, :conclusao3)');
				$cvc3->bindValue(':id', $idusuario);
				$cvc3->bindValue(':curso3', $_POST['cursoextra3']);
				$cvc3->bindValue(':instituicao3', $_POST['instextra3']);
				$cvc3->bindValue(':conclusao3', formataData($_POST['dataconcextra3'], 'mysql'));
				$cvc3->execute();
			}

			if(!empty($_POST['cursoextra4']) || !empty($_POST['instextra4']) || !empty($_POST['dataconcextra4'])){
				$cvc4 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso4, :instituicao4, :conclusao4)');
				$cvc4->bindValue(':id', $idusuario);
				$cvc4->bindValue(':curso4', $_POST['cursoextra4']);
				$cvc4->bindValue(':instituicao4', $_POST['instextra4']);
				$cvc4->bindValue(':conclusao4', formataData($_POST['dataconcextra4'], 'mysql'));
				$cvc4->execute();
			}

			if(!empty($_POST['cursoextra5']) || !empty($_POST['instextra5']) || !empty($_POST['dataconcextra5'])){
				$cvc5 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso5, :instituicao5, :conclusao5)');
				$cvc5->bindValue(':id', $idusuario);
				$cvc5->bindValue(':curso5', $_POST['cursoextra5']);
				$cvc5->bindValue(':instituicao5', $_POST['instextra5']);
				$cvc5->bindValue(':conclusao5', formataData($_POST['dataconcextra5'], 'mysql'));
				$cvc5->execute();
			}

			$cvo = $pdo->prepare('INSERT INTO cv_extras (id_usuario, sobreavaga, comentarios) VALUES(:id, :sobreavaga, :comentarios)');
			$cvo -> bindValue(':id', $idusuario);
			$cvo -> bindValue(':sobreavaga', $_POST['comosoube']);
			$cvo -> bindValue(':comentarios', $_POST['comentarios']);
	
			if($cvo -> execute()){
				echo '<script type="text/javascript">
				window.location = "usuario.php?pag=cadcv"
				</script>';
			}
		}
	break;

	case 'detalhesCV':
		$idcv = $_REQUEST['idcv'];
		$pdo = Database::conexao();

		$det = $pdo->prepare('SELECT email FROM cv_usuarios WHERE id = :idcv');
		$det -> bindValue(':idcv', $idcv);

		$det2 = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :idcv');
		$det2 -> bindValue(':idcv', $idcv);

		$det3 = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :idcv');
		$det3 -> bindValue(':idcv', $idcv);

		$det4 = $pdo->prepare('SELECT * FROM cv_formacao WHERE id_usuario = :idcv');
		$det4 -> bindValue(':idcv', $idcv);

		$det5 = $pdo->prepare('SELECT * FROM cv_adicionais WHERE id_usuario = :idcv');
		$det5 -> bindValue(':idcv', $idcv);
		
		$det6 = $pdo->prepare('SELECT * FROM cv_experiencia WHERE id_usuario = :idcv');
		$det6 -> bindValue(':idcv', $idcv);

		$det7 = $pdo->prepare('SELECT * FROM cv_capacitacao WHERE id_usuario = :idcv');
		$det7 -> bindValue(':idcv', $idcv);

		$det8 = $pdo->prepare('SELECT * FROM cv_extras WHERE id_usuario = :idcv');
		$det8 -> bindValue(':idcv', $idcv);

		if($det->execute() && $det2->execute() && $det3->execute() && $det4->execute() && $det5->execute() && $det6->execute() && $det7->execute() && $det8->execute()){
			$cv  = $det->fetch(PDO::FETCH_ASSOC);
			$cv2 = $det2->fetch(PDO::FETCH_ASSOC);
			$cv3 = $det3->fetch(PDO::FETCH_ASSOC);
			$cv5 = $det5->fetch(PDO::FETCH_ASSOC);
			$cv8 = $det8->fetch(PDO::FETCH_ASSOC);
		}
	break;

	case "editacv":
		if(!isset($_SESSION)) session_start();
		$idcv = $_SESSION['rgr']['usuarioId'];

		$pdo = Database::conexao();
		$det = $pdo->prepare('SELECT email FROM cv_usuarios WHERE id = :idcv');
		$det -> bindValue(':idcv', $idcv);

		$det2 = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :idcv');
		$det2 -> bindValue(':idcv', $idcv);

		$det3 = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :idcv');
		$det3 -> bindValue(':idcv', $idcv);

		$det4 = $pdo->prepare('SELECT * FROM cv_formacao WHERE id_usuario = :idcv');
		$det4 -> bindValue(':idcv', $idcv);

		$det5 = $pdo->prepare('SELECT * FROM cv_adicionais WHERE id_usuario = :idcv');
		$det5 -> bindValue(':idcv', $idcv);

		$det6 = $pdo->prepare('SELECT * FROM cv_experiencia WHERE id_usuario = :idcv');
		$det6 -> bindValue(':idcv', $idcv);

		$det7 = $pdo->prepare('SELECT * FROM cv_capacitacao WHERE id_usuario = :idcv');
		$det7 -> bindValue(':idcv', $idcv);

		$det8 = $pdo->prepare('SELECT * FROM cv_extras WHERE id_usuario = :idcv');
		$det8 -> bindValue(':idcv', $idcv);

		if($det->execute() && $det2->execute() && $det3->execute() && $det4->execute() && $det5->execute() && $det6->execute() && $det7->execute() && $det8->execute()){
			$cv  = $det->fetch(PDO::FETCH_ASSOC);
			$cv2 = $det2->fetch(PDO::FETCH_ASSOC);
			$cv3 = $det3->fetch(PDO::FETCH_ASSOC);
			$cv5 = $det5->fetch(PDO::FETCH_ASSOC);
			$cv8 = $det8->fetch(PDO::FETCH_ASSOC);
			
			$numcv = $det2->rowCount();
		}
	break;

	case "atualizacv":

		if(!isset($_SESSION)) session_start();
		$idcv = $_SESSION['rgr']['usuarioId'];

		$pdo = Database::conexao();

		//busca cpf para garantir que o usuário não irá atualizar o cv e utilizar um cpf que já existe no bd
		$cpf = $pdo->prepare('SELECT cpf FROM cv_documentos WHERE cpf = :cpf AND id_usuario != :id_usuario');
		$cpf -> bindValue(':cpf',$_POST['cpf']);
		$cpf -> bindValue(':id_usuario', $idcv);
		$cpf -> execute();

		if($cpf->rowCount() > 0){
			$classecv = 'erro';
			$statusatt = 'ok';
			$avisoCV = 'O CPF informado já existe no banco de dados. Se você já possui outro cadastro, é necessário excluir o cadastro anterior';
			$numcv = 1;
		}else{

		$cvp = $pdo->prepare('INSERT INTO cv_pessoais (id_usuario, nome, genero, estadocivil, nascimento, pcd, tipopcd, cid, filhos, qtyfilhos, endereco, numero, complemento, cep, bairro, cidade, uf, tel_res, tel_cel, tel_com, aoscuidados, naturalidade, nacionalidade, mae, pai) VALUES (:id, :nome, :genero, :estadocivil, :nascimento, :pcd, :tipopcd, :cid, :filhos, :qtyfilhos, :endereco, :numero, :complemento, :cep, :bairro, :cidade, :uf, :tel_res, :tel_cel, :tel_com, :aoscuidados, :naturalidade, :nacionalidade, :mae, :pai )

		ON DUPLICATE KEY UPDATE nome = :nome2, genero = :genero2, estadocivil = :estadocivil2, nascimento = :nascimento2, pcd = :pcd2, tipopcd = :tipopcd2, cid = :cid2, filhos = :filhos2, qtyfilhos = :qtyfilhos2, endereco = :endereco2, numero = :numero2, complemento = :complemento2, cep = :cep2, bairro = :bairro2, cidade = :cidade2, uf = :uf2, tel_res = :tel_res2, tel_cel = :tel_cel2, tel_com = :tel_com2, aoscuidados = :aoscuidados2, naturalidade = :naturalidade2, nacionalidade = :nacionalidade2, mae = :mae2, pai = :pai2');

		$cvp->bindValue(':id', $idcv);
		$cvp->bindValue(':nome', $_POST['nome']);
		$cvp->bindValue(':genero', $_POST['genero']);
		$cvp->bindValue(':estadocivil', $_POST['estadocivil']);
		$cvp->bindValue(':nascimento', formataData($_POST['nascimento'], 'mysql'));
		$cvp->bindValue(':pcd', $_POST['pcd']);
		$cvp->bindValue(':tipopcd', $_POST['deficiencia']);
		$cvp->bindValue(':cid', $_POST['cid']);
		$cvp->bindValue(':filhos', $_POST['filhos']);
		$cvp->bindValue(':qtyfilhos', $_POST['qtyfilhos']);
		$cvp->bindValue(':endereco', $_POST['rua']);
		$cvp->bindValue(':numero', $_POST['numero']);
		$cvp->bindValue(':complemento', $_POST['complemento']);
		$cvp->bindValue(':cep', $_POST['cep']);
		$cvp->bindValue(':bairro', $_POST['bairro']);
		$cvp->bindValue(':cidade', $_POST['cidade']);
		$cvp->bindValue(':uf', $_POST['uf']);
		$cvp->bindValue(':tel_res', $_POST['tel_res']);				
		$cvp->bindValue(':tel_cel', $_POST['tel_cel']);
		$cvp->bindValue(':tel_com', $_POST['tel_com']);
		$cvp->bindValue(':aoscuidados', $_POST['recados']);
		$cvp->bindValue(':naturalidade', $_POST['naturalidade']);
		$cvp->bindValue(':nacionalidade', $_POST['nacionalidade']);
		$cvp->bindValue(':mae', $_POST['mae']);
		$cvp->bindValue(':pai', $_POST['pai']);


		$cvp->bindValue(':nome2', $_POST['nome']);
		$cvp->bindValue(':genero2', $_POST['genero']);
		$cvp->bindValue(':estadocivil2', $_POST['estadocivil']);
		$cvp->bindValue(':nascimento2', formataData($_POST['nascimento'], 'mysql'));
		$cvp->bindValue(':pcd2', $_POST['pcd']);
		$cvp->bindValue(':tipopcd2', $_POST['deficiencia']);
		$cvp->bindValue(':cid2', $_POST['cid']);
		$cvp->bindValue(':filhos2', $_POST['filhos']);
		$cvp->bindValue(':qtyfilhos2', $_POST['qtyfilhos']);
		$cvp->bindValue(':endereco2', $_POST['rua']);
		$cvp->bindValue(':numero2', $_POST['numero']);
		$cvp->bindValue(':complemento2', $_POST['complemento']);
		$cvp->bindValue(':cep2', $_POST['cep']);
		$cvp->bindValue(':bairro2', $_POST['bairro']);
		$cvp->bindValue(':cidade2', $_POST['cidade']);
		$cvp->bindValue(':uf2', $_POST['uf']);
		$cvp->bindValue(':tel_res2', $_POST['tel_res']);				
		$cvp->bindValue(':tel_cel2', $_POST['tel_cel']);
		$cvp->bindValue(':tel_com2', $_POST['tel_com']);
		$cvp->bindValue(':aoscuidados2', $_POST['recados']);
		$cvp->bindValue(':naturalidade2', $_POST['naturalidade']);
		$cvp->bindValue(':nacionalidade2', $_POST['nacionalidade']);
		$cvp->bindValue(':mae2', $_POST['mae']);
		$cvp->bindValue(':pai2', $_POST['pai']);
		$cvp->execute();

		$cvd = $pdo->prepare('INSERT INTO cv_documentos (id_usuario, rg, emissor, uf, cpf, cnh, categoria, ctps, serie, pispasep, reservista, contacaixa) VALUES(:id2, :rg, :emissor, :uf, :cpf, :cnh, :categoria, :ctps, :serie, :pispasep, :reservista, :contacaixa)

		ON DUPLICATE KEY UPDATE rg = :rg2, emissor = :emissor2, uf = :uf2, cpf = :cpf2, cnh = :cnh2, categoria = :categoria2, ctps = :ctps2, serie = :serie2, pispasep = :pispasep2, reservista = :reservista2, contacaixa = :contacaixa2');
		$cvd -> bindValue(':id2', $idcv);
		$cvd -> bindValue(':rg', $_POST['rg']);
		$cvd -> bindValue(':emissor', $_POST['emissor']);
		$cvd -> bindValue(':uf', $_POST['uf']);
		$cvd -> bindValue(':cpf', $_POST['cpf']);
		$cvd -> bindValue(':cnh', $_POST['cnh']);
		$cvd -> bindValue(':categoria', $_POST['categoria']);
		$cvd -> bindValue(':ctps', $_POST['ctps']);
		$cvd -> bindValue(':serie', $_POST['serie']);
		$cvd -> bindValue(':pispasep', $_POST['pispasep']);
		$cvd -> bindValue(':reservista', $_POST['reservista']);
		$cvd -> bindValue(':contacaixa', $_POST['conta']);
		
		$cvd -> bindValue(':rg2', $_POST['rg']);
		$cvd -> bindValue(':emissor2', $_POST['emissor']);
		$cvd -> bindValue(':uf2', $_POST['uf']);
		$cvd -> bindValue(':cpf2', $_POST['cpf']);
		$cvd -> bindValue(':cnh2', $_POST['cnh']);
		$cvd -> bindValue(':categoria2', $_POST['categoria']);
		$cvd -> bindValue(':ctps2', $_POST['ctps']);
		$cvd -> bindValue(':serie2', $_POST['serie']);
		$cvd -> bindValue(':pispasep2', $_POST['pispasep']);
		$cvd -> bindValue(':reservista2', $_POST['reservista']);
		$cvd -> bindValue(':contacaixa2', $_POST['conta']);
		$cvd -> execute();

		$dcvf = $pdo->prepare('DELETE FROM cv_formacao WHERE id_usuario = :id');
		$dcvf -> bindValue(':id', $idcv);
		$dcvf -> execute();

		if(!empty($_POST['instituicao1']) || !empty($_POST['curso1']) || !empty($_POST['status1']) || !empty($_POST['conclusao1'])){
			$cvf = $pdo->prepare('INSERT INTO cv_formacao (id_usuario, instituicao, nome_curso, status, conclusao, tipograduacao) VALUES(:id, :instituicao, :nome_curso, :status, :conclusao, :tipograduacao)');

			$cvf -> bindValue(':id', $idcv);
			$cvf -> bindValue(':instituicao', $_POST['instituicao1']);
			$cvf -> bindValue(':nome_curso', $_POST['curso1']);
			$cvf -> bindValue(':status', $_POST['status1']);
			$cvf -> bindValue(':conclusao', $_POST['conclusao1']);
			$cvf -> bindValue(':tipograduacao', $_POST['tipoGrad1']);
			$cvf->execute();
		}

		if(!empty($_POST['instituicao2']) || !empty($_POST['curso2']) || !empty($_POST['status2']) || !empty($_POST['conclusao2'])){
			$cvf2 = $pdo->prepare('INSERT INTO cv_formacao (id_usuario, instituicao, nome_curso, status, conclusao, tipograduacao) VALUES(:id, :instituicao2, :nome_curso2, :status2, :conclusao2, :tipograduacao2)');
			$cvf2 -> bindValue(':id', $idcv);
			$cvf2 -> bindValue(':instituicao2', $_POST['instituicao2']);
			$cvf2 -> bindValue(':nome_curso2', $_POST['curso2']);
			$cvf2 -> bindValue(':status2', $_POST['status2']);
			$cvf2 -> bindValue(':conclusao2', $_POST['conclusao2']);
			$cvf2 -> bindValue(':tipograduacao2', $_POST['tipoGrad2']);
			$cvf2->execute();
		}

			$cva = $pdo->prepare('INSERT INTO cv_adicionais (id_usuario, disp_trabalho, disp_viagem, veiculo, trabalha_estado, trabalha_estado_orgao, trabalhou_estado, trabalhou_estado_orgao, trabalhou_estado_local, trabalhou_estado_contratacao, trabalhou_estado_tempo, parente, parente_area, parente_grau, parente_nome) VALUES(:id, :disp_trabalho, :disp_viagem, :veiculo, :trabalha_estado, :trabalha_estado_orgao, :trabalhou_estado, :trabalhou_estado_orgao, :trabalhou_estado_local, :trabalhou_estado_contratacao, :trabalhou_estado_tempo, :parente, :parente_area, :parente_grau, :parente_nome)

			ON DUPLICATE KEY UPDATE disp_trabalho = :disp_trabalho2, disp_viagem = :disp_viagem2, veiculo = :veiculo2, trabalha_estado = :trabalha_estado2, trabalha_estado_orgao = :trabalha_estado_orgao2, trabalhou_estado = :trabalhou_estado2, trabalhou_estado_orgao = :trabalhou_estado_orgao2, trabalhou_estado_local = :trabalhou_estado_local2, trabalhou_estado_contratacao = :trabalhou_estado_contratacao2, trabalhou_estado_tempo = :trabalhou_estado_tempo2, parente = :parente2, parente_area = :parente_area2, parente_grau = :parente_grau2, parente_nome = :parente_nome2');

			$cva->bindValue(':id', $idcv);
			$cva->bindValue(':disp_trabalho', $_POST['fds']);
			$cva->bindValue(':disp_viagem', $_POST['viagens']);
			$cva->bindValue(':veiculo', $_POST['veiculo']);
			$cva->bindValue(':trabalha_estado', $_POST['trabalha_estado']);
			$cva->bindValue(':trabalha_estado_orgao', $_POST['orgaotrabalha']);
			$cva->bindValue(':trabalhou_estado', $_POST['trabalhou_estado']);
			$cva->bindValue(':trabalhou_estado_orgao', $_POST['orgaotrabalhou']);
			$cva->bindValue(':trabalhou_estado_local', $_POST['local']);
			$cva->bindValue(':trabalhou_estado_contratacao', $_POST['tipocontratacao']);
			$cva->bindValue(':trabalhou_estado_tempo', $_POST['qtotempo']);
			$cva->bindValue(':parente', $_POST['parentes']);
			$cva->bindValue(':parente_area', $_POST['atuacao']);
			$cva->bindValue(':parente_grau', $_POST['grau']);
			$cva->bindValue(':parente_nome', $_POST['nomeparente']);
			
			$cva->bindValue(':disp_trabalho2', $_POST['fds']);
			$cva->bindValue(':disp_viagem2', $_POST['viagens']);
			$cva->bindValue(':veiculo2', $_POST['veiculo']);
			$cva->bindValue(':trabalha_estado2', $_POST['trabalha_estado']);
			$cva->bindValue(':trabalha_estado_orgao2', $_POST['orgaotrabalha']);
			$cva->bindValue(':trabalhou_estado2', $_POST['trabalhou_estado']);
			$cva->bindValue(':trabalhou_estado_orgao2', $_POST['orgaotrabalhou']);
			$cva->bindValue(':trabalhou_estado_local2', $_POST['local']);
			$cva->bindValue(':trabalhou_estado_contratacao2', $_POST['tipocontratacao']);
			$cva->bindValue(':trabalhou_estado_tempo2', $_POST['qtotempo']);
			$cva->bindValue(':parente2', $_POST['parentes']);
			$cva->bindValue(':parente_area2', $_POST['atuacao']);
			$cva->bindValue(':parente_grau2', $_POST['grau']);
			$cva->bindValue(':parente_nome2', $_POST['nomeparente']);
			$cva->execute();

			/* ATUALIZA EXPERIENCIA */
			$dcve = $pdo->prepare('DELETE FROM cv_experiencia WHERE id_usuario = :id');
			$dcve -> bindValue(':id', $idcv);
			$dcve -> execute();

			if(!empty($_POST['nomeempresa1']) || !empty($_POST['cidadeempresa1']) || !empty($_POST['telempresa1']) || !empty($_POST['cargoempresa1']) || !empty($_POST['datainicio1']) || !empty($_POST['datasaida1']) || !empty($_POST['atividades1']) || !empty($_POST['ultimaremuneracao1']) || !empty($_POST['motivosaida1']) || !empty($_POST['referencia1']) || !empty($_POST['telref1'])){

			$cve = $pdo->prepare('INSERT INTO cv_experiencia (id_usuario, nome_empresa, cidade, telefone, cargo, inicio, termino, atividades, remuneracao, motivo_saida, ref_nome, ref_tel) VALUES (:id, :nome_empresa, :cidade, :telefone, :cargo, :inicio, :termino, :atividades, :remuneracao, :motivo_saida, :ref_nome, :ref_tel)');

			$cve -> bindValue(':id', $idcv);
			$cve -> bindValue(':nome_empresa', $_POST['nomeempresa1']);
			$cve -> bindValue(':cidade', $_POST['cidadeempresa1']);
			$cve -> bindValue(':telefone', $_POST['telempresa1']);
			$cve -> bindValue(':cargo', $_POST['cargoempresa1']);
			$cve -> bindValue(':inicio', formataData($_POST['datainicio1'], 'mysql'));
			$cve -> bindValue(':termino', formataData($_POST['datasaida1'], 'mysql'));
			$cve -> bindValue(':atividades', $_POST['atividades1']);
			$cve -> bindValue(':remuneracao', $_POST['ultimaremuneracao1']);
			$cve -> bindValue(':motivo_saida', $_POST['motivosaida1']);
			$cve -> bindValue(':ref_nome', $_POST['referencia1']);
			$cve -> bindValue(':ref_tel', $_POST['telref1']);
			$cve->execute();
			}

			if(!empty($_POST['nomeempresa2']) || !empty($_POST['cidadeempresa2']) || !empty($_POST['telempresa2']) || !empty($_POST['cargoempresa2']) || !empty($_POST['datainicio2']) || !empty($_POST['datasaida2']) || !empty($_POST['atividades2']) || !empty($_POST['ultimaremuneracao2']) || !empty($_POST['motivosaida2']) || !empty($_POST['referencia2']) || !empty($_POST['telref2'])){

			$cve2 = $pdo->prepare('INSERT INTO cv_experiencia (id_usuario, nome_empresa, cidade, telefone, cargo, inicio, termino, atividades, remuneracao, motivo_saida, ref_nome, ref_tel) VALUES (:id, :nome_empresa2, :cidade2, :telefone2, :cargo2, :inicio2, :termino2, :atividades2, :remuneracao2, :motivo_saida2, :ref_nome2, :ref_tel2)');

			$cve2 -> bindValue(':id', $idcv);
			$cve2 -> bindValue(':nome_empresa2', $_POST['nomeempresa2']);
			$cve2 -> bindValue(':cidade2', $_POST['cidadeempresa2']);
			$cve2 -> bindValue(':telefone2', $_POST['telempresa2']);
			$cve2 -> bindValue(':cargo2', $_POST['cargoempresa2']);
			$cve2 -> bindValue(':inicio2', formataData($_POST['datainicio2'], 'mysql'));
			$cve2 -> bindValue(':termino2', formataData($_POST['datasaida2'], 'mysql'));
			$cve2 -> bindValue(':atividades2', $_POST['atividades2']);
			$cve2 -> bindValue(':remuneracao2', $_POST['ultimaremuneracao2']);
			$cve2 -> bindValue(':motivo_saida2', $_POST['motivosaida2']);
			$cve2 -> bindValue(':ref_nome2', $_POST['referencia2']);
			$cve2 -> bindValue(':ref_tel2', $_POST['telref2']);
			$cve2->execute();
			}

			/* CAPACITAÇÃO / CURSOS */
			$dcvc = $pdo->prepare('DELETE FROM cv_capacitacao WHERE id_usuario = :id');
			$dcvc -> bindValue(':id', $idcv);
			$dcvc ->execute();

			if(!empty($_POST['cursoextra1']) || !empty($_POST['instextra1']) || !empty($_POST['dataconcextra1'])){
				$cvc = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso, :instituicao, :conclusao)');
				$cvc->bindValue(':id', $idcv);
				$cvc->bindValue(':curso', $_POST['cursoextra1']);
				$cvc->bindValue(':instituicao', $_POST['instextra1']);
				$cvc->bindValue(':conclusao', formataData($_POST['dataconcextra1'], 'mysql'));
				$cvc->execute();
			}

			if(!empty($_POST['cursoextra2']) || !empty($_POST['instextra2']) || !empty($_POST['dataconcextra2'])){
				$cvc2 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso2, :instituicao2, :conclusao2)');
				$cvc2->bindValue(':id', $idcv);
				$cvc2->bindValue(':curso2', $_POST['cursoextra2']);
				$cvc2->bindValue(':instituicao2', $_POST['instextra2']);
				$cvc2->bindValue(':conclusao2', formataData($_POST['dataconcextra2'], 'mysql'));
				$cvc2->execute();
			}

			if(!empty($_POST['cursoextra3']) || !empty($_POST['instextra3']) || !empty($_POST['dataconcextra3'])){
				$cvc3 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso3, :instituicao3, :conclusao3)');
				$cvc3->bindValue(':id', $idcv);
				$cvc3->bindValue(':curso3', $_POST['cursoextra3']);
				$cvc3->bindValue(':instituicao3', $_POST['instextra3']);
				$cvc3->bindValue(':conclusao3', formataData($_POST['dataconcextra3'], 'mysql'));
				$cvc3->execute();
			}

			if(!empty($_POST['cursoextra4']) || !empty($_POST['instextra4']) || !empty($_POST['dataconcextra4'])){
				$cvc4 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso4, :instituicao4, :conclusao4)');
				$cvc4->bindValue(':id', $idcv);
				$cvc4->bindValue(':curso4', $_POST['cursoextra4']);
				$cvc4->bindValue(':instituicao4', $_POST['instextra4']);
				$cvc4->bindValue(':conclusao4', formataData($_POST['dataconcextra4'], 'mysql'));
				$cvc4->execute();
			}

			if(!empty($_POST['cursoextra5']) || !empty($_POST['instextra5']) || !empty($_POST['dataconcextra5'])){

				$cvc5 = $pdo->prepare('INSERT INTO cv_capacitacao (id_usuario, curso, instituicao, conclusao) VALUES (:id, :curso5, :instituicao5, :conclusao5)');
				$cvc5->bindValue(':id', $idcv);
				$cvc5->bindValue(':curso5', $_POST['cursoextra5']);
				$cvc5->bindValue(':instituicao5', $_POST['instextra5']);
				$cvc5->bindValue(':conclusao5', formataData($_POST['dataconcextra5'], 'mysql'));
				$cvc5->execute();
			}

			$cvo = $pdo->prepare('INSERT INTO cv_extras (id_usuario, sobreavaga, comentarios) VALUES(:id, :sobreavaga, :comentarios)
			ON DUPLICATE KEY UPDATE sobreavaga = :sobreavaga2, comentarios = :comentarios2');
			$cvo -> bindValue(':id', $idcv);
			$cvo -> bindValue(':sobreavaga', $_POST['comosoube']);
			$cvo -> bindValue(':comentarios', $_POST['comentarios']);
			$cvo -> bindValue(':sobreavaga2', $_POST['comosoube']);
			$cvo -> bindValue(':comentarios2', $_POST['comentarios']);
			$cvo -> execute();

			$cvu = $pdo->prepare('UPDATE cv_usuarios SET email = :email WHERE id = :id');
			$cvu -> bindValue(':email', $_POST['email']);
			$cvu -> bindValue(':id', $idcv);
			$cvu -> execute();

			$avisoCV = 'Seu currículo foi atualizado. Caso tenha alterado seu e-mail, utilize o novo email para acessar sua conta.';
			$classecv = 'ok';
			$statusatt = 'ok';
			$numcv = 1;
		}
	break;

	case "pgexcluicv":
		if(!isset($_SESSION)) session_start();
		$idUsuario = $_SESSION['rgr']['usuarioId'];

		$pdo = Database::conexao();
		$bcv = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :idusuario');
		$bcv -> bindValue(':idusuario', $idUsuario);
		$bcv -> execute();
		$qtyCv = $bcv->rowCount();
		$numcv = $qtyCv;
	break;

	case "excluicv":

		if(!isset($_SESSION)) session_start();
		$idcv = $_SESSION['rgr']['usuarioId'];

		grava_exclusao($idcv);

		$pdo = Database::conexao();
		$cv1 = $pdo->prepare('DELETE FROM cv_pessoais WHERE id_usuario = :id');
		$cv2 = $pdo->prepare('DELETE FROM cv_documentos WHERE id_usuario = :id');
		$cv3 = $pdo->prepare('DELETE FROM cv_formacao WHERE id_usuario = :id');
		$cv4 = $pdo->prepare('DELETE FROM cv_adicionais WHERE id_usuario = :id');
		$cv5 = $pdo->prepare('DELETE FROM cv_experiencia WHERE id_usuario = :id');
		$cv6 = $pdo->prepare('DELETE FROM cv_capacitacao WHERE id_usuario = :id');
		$cv7 = $pdo->prepare('DELETE FROM cv_extras WHERE id_usuario = :id');		
		$cv8 = $pdo->prepare('DELETE FROM ps_candidatos WHERE id_usuario = :id');
		

		$cv1 -> bindValue(':id', $idcv);
		$cv2 -> bindValue(':id', $idcv);
		$cv3 -> bindValue(':id', $idcv);
		$cv4 -> bindValue(':id', $idcv);
		$cv5 -> bindValue(':id', $idcv);
		$cv6 -> bindValue(':id', $idcv);
		$cv7 -> bindValue(':id', $idcv);
		$cv8 -> bindValue(':id', $idcv);

		if($cv1 -> execute() && $cv2 -> execute() && $cv3 -> execute() && $cv4 -> execute() && $cv5 -> execute() && $cv6 -> execute() && $cv7 -> execute() && $cv8 -> execute()){
			$avisoCV = 'Seu currículo foi excluído';
			$classecv = 'ok';
		}
	break;

	case "cadVaga":
		if($erro ==0){
			$pdo = Database::conexao();
			$cad = $pdo->prepare('INSERT INTO ps_vagas (cargo, local, atribuicoes, formacao, vagas, carga, turno, salario, numero, edital) 
			VALUES(:cargo, :local, :atribuicoes, :formacao, :vagas, :carga, :turno, :salario, :numero, :edital)');
			$cad -> bindValue(':cargo', $_POST['cargo']);
			$cad -> bindValue(':local', $_POST['local']);
			$cad -> bindValue(':atribuicoes', $_POST['atribuicoes']);
			$cad -> bindValue(':formacao', $_POST['formacao']);
			$cad -> bindValue(':vagas', $_POST['vagas']);
			$cad -> bindValue(':carga', $_POST['cargah']);
			$cad -> bindValue(':turno', $_POST['turno']);
			$cad -> bindValue(':salario', $_POST['salario']);
			$cad -> bindValue(':numero', $_POST['nvaga']);
			$cad -> bindValue(':edital', $_POST['edital']);
					
			if($cad -> execute()){
				$classev = 'ok';
				$avisoV = 'A vaga foi cadastrada!';
			}
		}
	break;

	case "excluivaga":
		$idvaga = $_POST['idvaga'];
		try{
			$pdo = Database::conexao();
			$stmt = $pdo->prepare('DELETE FROM ps_vagas WHERE id = ?');
			$stmt -> bindParam(1, $idvaga, PDO::PARAM_STR);
			$executa = $stmt -> execute();
			
			if($executa){
				$resposta = array(
					'statusQuery'     => 1,
					'classeResultado' => 'okQuery',
					'resultadoQuery'  => ' foi apagada com sucesso'
				);
				echo json_encode($resposta);
			}
		}
		catch(PDOException $e){
			$resposta = array(
				'statusQuery'     => 0,
				'classeResultado' => 'erroQuery',
				'resultadoQuery'  => 'Ocorreu um erro, informe a mensagem abaixo para o desenvolvedor: <br><i>'.$e->getMessage().'</i>'
			);
			echo json_encode($resposta);
		}
	break;

	case "editavaga":
		$idvaga = $_REQUEST['id'];
		$pdo = Database::conexao();
		$evg = $pdo->prepare('SELECT * FROM ps_vagas WHERE id = :id');
		$evg -> bindValue(':id', $idvaga);
		$evg ->execute();
		$vg = $evg->fetch(PDO::FETCH_ASSOC);
	break;

	case "atualizaVaga":
		$pdo = Database::conexao();
		$avg = $pdo->prepare('UPDATE ps_vagas SET cargo=:cargo, local = :local, atribuicoes = :atribuicoes, formacao = :formacao, vagas=:vagas, carga=:carga, turno = :turno, salario = :salario, numero = :numero, edital=:edital WHERE id = :id');
		$avg -> bindValue(':cargo', $_POST['cargo']);
		$avg -> bindValue(':local', $_POST['local']);
		$avg -> bindValue(':atribuicoes', $_POST['atribuicoes']);
		$avg -> bindValue(':formacao', $_POST['formacao']);
		$avg -> bindValue(':vagas', $_POST['vagas']);
		$avg -> bindValue(':carga', $_POST['cargah']);
		$avg -> bindValue(':turno', $_POST['turno']);
		$avg -> bindValue(':salario', $_POST['salario']);
		$avg -> bindValue(':numero', $_POST['nvaga']);
		$avg -> bindValue(':edital', $_POST['edital']);
		$avg -> bindValue(':id', $_POST['idVaga']);

		if($avg ->execute()){
			$classev = 'ok';
			$avisoV = 'A vaga foi atualizada';
		}
	break;

	case "detalhesVaga":
		$idVaga = $_REQUEST['idVaga'];

		$pdo = Database::conexao();
		$det = $pdo->prepare('SELECT ps_vagas.*, ps_edital.id as idEdital, ps_edital.status FROM ps_vagas,ps_edital 
			WHERE ps_vagas.edital = ps_edital.id
			AND ps_vagas.id = :idvaga');
		$det -> bindValue(':idvaga', $idVaga);
		$det -> execute();
		$vaga = $det->fetch(PDO::FETCH_ASSOC);

		if(!isset($_SESSION)) session_start();
		$idUsuario = $_SESSION['rgr']['usuarioId'];
		$bcv = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :idusuario');
		$bcv -> bindValue(':idusuario', $idUsuario);
		$bcv -> execute();
		$qtyCv = $bcv->rowCount();
		$numcv = $qtyCv;
	break;

	case "listacvs":
		try{
			$pdo = Database::conexao();
			// busca pela formacao, data de nascimento e nome de todos os usuários
			// count(f.id_usuario) conta quantas linhas de registro existem na tabela de formacao com o id do usuario
			// left join cv_formacao = mostra a linha mesmo que não haja registro na tabela f
			// right join cv_pessoais = mostra a linha somente se houver registro na tabela p
			
			if(!$_REQUEST['formName'] == 'frmBuscaCandidatos'){
				$lcv = $pdo->prepare('
					SELECT u.id, f.id_usuario, f.nome_curso, p.nome, p.nascimento, COUNT(f.id_usuario) as qtyFormacoes FROM cv_usuarios u
					LEFT JOIN cv_formacao f ON u.id = f.id_usuario
					INNER JOIN cv_pessoais p ON u.id = p.id_usuario
					GROUP BY u.id
					ORDER BY p.nome
				');
				$lcv -> execute();
			} else {
				$nome     = $_REQUEST['nome_candidato'];
				$formacao = $_REQUEST['formacao_candidato'];
				$pcd      = $_REQUEST['pcd_candidato'];
				$ordem    = $_REQUEST['ordenacao'];
				//$edital   = $_REQUEST['edital'];
				$where    = '';

				if($nome) { $where .= ' AND p.nome LIKE "%":nome_candidato"%"';}
				if($formacao) { $where .=' AND f.nome_curso LIKE "%":formacao_candidato"%"';}
				if($pcd) { $where .= ' AND p.pcd = :pcd';}
				//if($edital) {$where .= ' AND '}
				if(!$ordem) { $ordem = 'ASC';}

 				$lcv = $pdo->prepare('
					SELECT u.id, f.id_usuario, f.nome_curso, p.nome, p.nascimento, p.pcd, COUNT(f.id_usuario) as qtyFormacoes FROM cv_usuarios u
					LEFT JOIN cv_formacao f ON u.id = f.id_usuario
					INNER JOIN cv_pessoais p ON u.id = p.id_usuario
					WHERE 1=1 '.$where.'
					GROUP BY u.id
					ORDER BY p.nome '.$ordem.'
				');

				if($nome) { $lcv->bindValue(':nome_candidato', $_REQUEST['nome_candidato']);}
				if($formacao) { $lcv->bindValue(':formacao_candidato', $_REQUEST['formacao_candidato']);}
				if($pcd) { $lcv->bindValue(':pcd', $_REQUEST['pcd_candidato']);}

				$lcv -> execute();
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	break;

	case "buscaCV":
		$id = $_REQUEST['idCV'];

		$pdo = Database::conexao();
		$cv0 = $pdo->prepare('SELECT * FROM cv_usuarios WHERE id = :id');
		$cv0 -> bindValue(':id', $id);

		$cv  = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :id');
		$cv -> bindValue(':id', $id);

		$cv2  = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :id');
		$cv2 -> bindValue(':id', $id);

		$cv3  = $pdo->prepare('SELECT * FROM cv_formacao WHERE id_usuario = :id');
		$cv3 -> bindValue(':id', $id);

		$cv4  = $pdo->prepare('SELECT * FROM cv_adicionais WHERE id_usuario = :id');
		$cv4 -> bindValue(':id', $id);

		$cv5  = $pdo->prepare('SELECT * FROM cv_experiencia WHERE id_usuario = :id');
		$cv5 -> bindValue(':id', $id);
		
		$cv6 =  $pdo->prepare('SELECT * FROM cv_capacitacao WHERE id_usuario = :id');
		$cv6 -> bindValue(':id', $id);

		$cv7 =  $pdo->prepare('SELECT * FROM cv_extras WHERE id_usuario = :id');
		$cv7 -> bindValue(':id', $id);

		$cv8 = $pdo->prepare('
		SELECT ps_edital.numero as numEdital, ps_vagas.numero as numVg, ps_vagas.edital, ps_candidatos.id_usuario, ps_candidatos.datainscricao 
		FROM ps_edital, ps_vagas, ps_candidatos 
		WHERE ps_candidatos.id_usuario = :id AND ps_candidatos.id_vaga = ps_vagas.id AND ps_edital.id = ps_vagas.edital
		');
		$cv8 -> bindValue(':id', $id);
	
		$cv0 ->execute();
		$cv  ->execute();
		$cv2 ->execute();
		$cv3 ->execute();
		$cv4 ->execute();
		$cv5 ->execute();
		$cv6 ->execute();
		$cv7 ->execute();
		$cv8 ->execute();

		$cvm = $cv0 ->fetch(PDO::FETCH_ASSOC);
		$cvp = $cv  ->fetch(PDO::FETCH_ASSOC);
		$cvd = $cv2 ->fetch(PDO::FETCH_ASSOC);
		$cva = $cv4 ->fetch(PDO::FETCH_ASSOC);
		$cvx = $cv7 ->fetch(PDO::FETCH_ASSOC);

		//busca comprovantes enviados
		//diretório dos comprovantes
		$dir = REGER.'/pdf/comprovante/'.$id.'/';
		
		if (file_exists($dir) && is_dir($dir)) {
			$files = scandir($dir);
			$dir_exists = true;
		} else {
			$dir_exists = false;
		}
	break;

	case "recuperasenha":

		$pdo = Database::conexao();
		$rec = $pdo->prepare('SELECT * FROM cv_usuarios WHERE email = :email');
		$rec -> bindValue(':email', $_POST['email']);
		$rec -> execute();
		
		if($rec->rowCount() > 0){
			$r = $rec->fetch(PDO::FETCH_ASSOC);
			$id = $r['id'];
			
			$brs = $pdo->prepare('SELECT * FROM cv_esqueceusenha WHERE id_usuario = :id AND mail = :mail');
			$brs -> bindValue(':id', $id);
			$brs -> bindValue(':mail', $_POST['email']);
			$brs -> execute();
			
			if ($brs -> rowCount() != 0){
				$drs = $pdo->prepare('DELETE FROM cv_esqueceusenha WHERE id_usuario = :id');
				$drs -> bindValue(':id', $id);
				$drs -> execute();
			}
			
			$chave = sha1(uniqid( mt_rand(), true));
			$novas = $pdo->prepare('INSERT INTO cv_esqueceusenha (id_usuario, mail, hash) VALUES(:id, :mail, :hash)');
			$novas -> bindValue(':id', $id);
			$novas -> bindValue(':mail', $_POST['email']);
			$novas -> bindValue(':hash', $chave);
			
			if($novas -> execute()){
				$link = 'https://institutoreger.org.br/processoseletivo/recuperasenha.php?acao=novasenha&mail='.$_POST['email'].'&token='.$chave;
				$quebra_linha = "\n";
				$emailsender = "naoresponda@institutoreger.org.br";

				$headers = "MIME-Version: 1.1\n";
				$headers .= "Content-type: text/html; charset=UTF-8\n";
				$headers .= "From: Instituto Reger <naoresponda@institutoreger.org.br>\n"; // remetente
				$headers .= "Return-Path: naoresponda@institutoreger.org.br\n"; // return-path
				

				$msg  = '';
				$msg .= 'Você solicitou a recuperação da senha por e-mail<br>';
				$msg .= 'Clique no link abaixo para criar uma nova senha<br>';
				$msg .= '<a href="'.$link.'" target="_blank">Clique para recuperar sua senha</a>';


				if(!mail($_POST['email'], 'Instituto Reger - Nova Senha', $msg, $headers ,"-r".$emailsender)){ // Se for Postfix
				    mail($_POST['email'], 'Instituto Reger - Nova Senha', $msg, $headers );
				}
			}
		}

		$classer = 'ok';
		$avisor  = 'Caso haja um usuário registrado com o email informado, você receberá um email com as instruções para alterar sua senha! Lembre-se de verificar a caixa de Spam ou Lixo eletrônico';
	break;

	case "novasenha":

		$email = $_REQUEST['mail'];
		$token = $_REQUEST['token'];

		if(empty($email) || empty($token)){
			die('Dados incompletos, acesse novamente o link enviado para seu e-mail');
		}else {
			$pdo = Database::conexao();
			$brs = $pdo->prepare('SELECT * FROM cv_esqueceusenha WHERE mail = :mail AND hash = :token');
			$brs -> bindValue(':mail', $email);
			$brs -> bindValue(':token', $token);
			
			$brs->execute();
			
			if($brs->rowCount() == 1){
				$varrec = '
					<form method="post" name="novasenha" action="'.$_SERVER['PHP_SELF'].'?acao=cadNovaSenha" onsubmit="return validaNovaSenha(this);">
						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="senha" class="form-control" />
						</div>
						<div class="form-group">
							<label>Confirme a senha</label>
							<input type="password" name="senha2" class="form-control" />
						</div>
						<div class="form-group">
							<input type="hidden" name="email" value="'.$email.'" />
							<input type="hidden" name="token" value="'.$token.'" />
							<input type="submit" class=" btn btn-default vb form-control" value="Cadastrar nova senha" />
						</div>
					</form>
				';
			} else {
				$varrec = 'Os dados estão incorretos. Utilize o link enviado para o email';
			}
		}
	break;

	case "cadNovaSenha":
		if(!empty($_POST)){
			$email = $_POST['email'];
			$token = $_POST['token'];
			
			$pdo = Database::conexao();
			$brs = $pdo->prepare('SELECT * FROM cv_esqueceusenha WHERE mail = :mail AND hash = :token');
			$brs -> bindValue(':mail', $email);
			$brs -> bindValue(':token', $token);
			
			$brs->execute();
			
			if($brs -> rowCount() == 1){
				
				require_once ('PasswordHash.php');
	
				$phpass = new PasswordHash(8, FALSE);
				$hash = $phpass->HashPassword($_POST['senha']);
	
	
				$stmt = $pdo->prepare('UPDATE cv_usuarios SET senha = :senha WHERE email = :email');
				$stmt -> bindValue(':senha', $hash);
				$stmt -> bindValue(':email', $_POST['email']);
				if($stmt -> execute()){
					$varrec = 'Sua senha foi atualizada. <a href="index.php">Clique aqui</a> e faça login com seus novos dados de acesso';
				}
				
				$drs = $pdo->prepare('DELETE FROM cv_esqueceusenha WHERE mail = :mail AND hash = :token');
				$drs -> bindValue(':mail', $email);
				$drs -> bindValue(':token', $token);
				$drs->execute();
			}
		}
	break;

	case "consultacpf":
		$pdo = Database::conexao();
		$cpf = $pdo->prepare('SELECT cpf FROM cv_documentos WHERE cpf = :cpf');
		$cpf -> bindValue(':cpf', $_POST['cpf']);
		$cpf ->execute();
		
		if($cpf->rowCount() > 0){
			echo json_encode(1);
		}
	break;

	case "cadEdital":
		if($_POST['submitcadEdital']){
			list($erro, $msg, $nome, $uploaddir) = uploadMaterial();

			$pdo = Database::conexao();
			$edt = $pdo->prepare('INSERT INTO ps_edital (nome, numero, edital, status, inicio, termino) VALUES(:nome, :numero, :edital, :status, :inicio, :termino)');
			$edt -> bindValue(':nome', $_POST['nome']);
			$edt -> bindValue(':numero', $_POST['numero']);
			$edt -> bindValue(':edital', $nome);
			$edt -> bindValue(':status', $_POST['status']);
			$edt -> bindValue(':inicio', formataData($_POST['inicio'],'mysql'));
			$edt -> bindValue(':termino', formataData($_POST['termino'], 'mysql'));
			
			if( $edt -> execute()){
				$classev = 'ok';
				$avisoV = 'Edital cadastrado';
			}
		}	
	break;

	case "listaeditais":
		$pdo = Database::conexao();
		$edt = $pdo->prepare('SELECT * FROM ps_edital');
		$edt -> execute();
	break;

	case "editaEdital":
		$idedital = $_REQUEST['id'];

		$pdo = Database::conexao();
		$edt = $pdo->prepare('SELECT * FROM ps_edital WHERE id = :idedital');
		$edt -> bindValue(':idedital', $idedital);
		$edt -> execute();
		
		$e = $edt->fetch(PDO::FETCH_ASSOC);
	break;

	case "atualizaedital":
		if($_FILES['edital']['error'] <> 4){
			list($erro, $msg, $nome, $uploaddir) = uploadMaterial();
		} else {
			$nome = $_POST['pdf'];
		}

		$pdo = Database::conexao();
		$edt = $pdo->prepare('UPDATE ps_edital SET nome = :nome, numero = :numero, edital = :edital, status = :status, inicio = :inicio, termino = :termino WHERE id = :idedital');
		$edt -> bindValue(':nome', $_POST['nome']);
		$edt -> bindValue(':numero', $_POST['numero']);
		$edt -> bindValue(':edital', $nome);
		$edt -> bindValue(':status', $_POST['status']);
		$edt -> bindValue(':idedital', $_POST['idEdital']);
		$edt -> bindValue(':inicio', formataData($_POST['inicio'],'mysql'));
		$edt -> bindValue(':termino', formataData($_POST['termino'], 'mysql'));
		
		if($edt->execute()){
			$classev = 'ok';
			$avisoV = 'Edital atualizado';
		}
	break;

	case "excluiedital":
		$idedital = $_POST['idedital'];
		try{
			$pdo = Database::conexao();
			$vg = $pdo->prepare('SELECT edital FROM ps_edital WHERE id = ?');
			$vg -> bindParam(1, $idedital, PDO::PARAM_STR);
			$vg -> execute();
			$res = $vg->fetch(PDO::FETCH_ASSOC);

			$pathimg = $res['edital'];
			unlink(REGER.'/pdf/'.$pathimg);
		
			$stmt = $pdo->prepare('DELETE FROM ps_edital WHERE id = ?');
			$stmt -> bindParam(1, $idedital, PDO::PARAM_STR);
			$executa = $stmt -> execute();
			
			if($executa){
				$resposta = array(
					'statusQuery'     => 1,
					'classeResultado' => 'okQuery',
					'resultadoQuery'  => ' foi apagado com sucesso'
				);
				echo json_encode($resposta);
			}
		}

		catch(PDOException $e){
			$resposta = array(
				'statusQuery'     => 0,
				'classeResultado' => 'erroQuery',
				'resultadoQuery'  => 'Ocorreu um erro, informe a mensagem abaixo para o desenvolvedor: <br><i>'.$e->getMessage().'</i>'
			);
			echo json_encode($resposta);
		}
	break;

	case "cadArquivo":
		if($_POST['submitCadArq']){
			list($erro, $msg, $nome, $uploaddir) = uploadMaterial();

			$pdo = Database::conexao();
			$edt = $pdo->prepare('INSERT INTO ps_arquivos (nome, arquivo, id_edital, data) VALUES(:nome, :arquivo, :idedital, :data)');
			$edt -> bindValue(':nome', $_POST['nome']);
			$edt -> bindValue(':arquivo', $nome);
			$edt -> bindValue(':idedital', $_POST['edital']);
			$edt -> bindValue(':data', formataData($_POST['data'], 'mysql'));
			
			if( $edt -> execute()){
				$classev = 'ok';
				$avisoV = 'Arquivo cadastrado';
			}
		}	
	break;

	case "listaarquivos":
		$pdo = Database::conexao();
		$arq = $pdo->prepare('SELECT * FROM ps_arquivos ORDER BY id_edital, data ASC');
		$arq -> execute();
	break;

	case "excluiarquivo":
		$idarq = $_POST['idarq'];
		$arq   = $_POST['arq'];

		unlink(REGER.'/pdf/'.$arq);
		
		$pdo = Database::conexao();
		$stmt = $pdo->prepare('DELETE FROM ps_arquivos WHERE id = ?');
		$stmt -> bindParam(1, $idarq, PDO::PARAM_STR);
		$executa = $stmt -> execute();

		if($executa){
			$resposta = array(
				'statusQuery'     => 1,
				'classeResultado' => 'ok',
				'resultadoQuery'  => ' foi apagado com sucesso'
			);
			echo json_encode($resposta);
		}
	break;

	case "editaArquivo":
		$idarq = $_REQUEST['id'];
		
		$pdo = Database::conexao();
		$edt = $pdo->prepare('SELECT * FROM ps_arquivos WHERE id = :idarq');
		$edt -> bindValue(':idarq', $idarq);
		$edt -> execute();
		
		$arq = $edt->fetch(PDO::FETCH_ASSOC);
	break;

	case "atualizaArquivo":
		if($_FILES['edital']['error'] <> 4){
			list($erro, $msg, $nome, $uploaddir) = uploadMaterial();
		} else {
			$nome = $_POST['pdf'];
		}

		$pdo = Database::conexao();
		$edt = $pdo->prepare('UPDATE ps_arquivos SET nome = :nome, arquivo = :arquivo, id_edital = :id_edital, data = :data WHERE id = :id');
		$edt -> bindValue(':nome', $_POST['nome']);
		$edt -> bindValue(':arquivo', $nome);
		$edt -> bindValue(':id_edital', $_POST['edital']);
		$edt -> bindValue(':data', formataData($_POST['data'], 'mysql'));
		$edt -> bindValue(':id', $_POST['idArq']);
		
		if($edt->execute()){
			$classev = 'ok';
			$avisoV = 'Edital atualizado';
		}
	break;

	case "inicial":
		$pdo = Database::conexao();
		$listaf = $pdo->prepare('SELECT * FROM ps_edital WHERE status = :status');
		$listaf -> bindValue(':status', 'Processo finalizado');
		$listaf -> execute();
	
		$listav = $pdo->prepare('SELECT * FROM ps_edital WHERE status != :status');
		$listav -> bindValue(':status', 'Processo finalizado');
		$listav -> execute();
		$numPsAberto = $listav->rowCount();
	break;

	case "detalhesEdital":
		$id_edital = $_GET['id'];

		$pdo = Database::conexao();
		$det = $pdo->prepare('
			SELECT e.id, e.numero as numEdital, e.edital as pdfEdital, v.edital, v.numero as numVaga, v.cargo, v.formacao, v.local
			FROM ps_edital e, ps_vagas v
			WHERE e.id = :idEdital
			AND e.id = v.edital
			ORDER BY v.numero ASC
			');
		$det -> bindValue(':idEdital', $id_edital);
		$det -> execute();
		$numDet = $det->rowCount();

		$arq = $pdo->prepare('SELECT * FROM ps_arquivos WHERE id_edital = :id_edital ORDER BY data ASC');
		$arq -> bindValue(':id_edital', $id_edital);
		$arq -> execute();
		$numArq = $arq->rowCount();

		$edt = $pdo->prepare('SELECT e.numero, e.edital FROM ps_edital e WHERE id = :idedital LIMIT 1');
		$edt -> bindValue(':idedital', $id_edital);
		$edt -> execute();
		$edital = $edt->fetch(PDO::FETCH_ASSOC);
	break;

	case "listaVGUsuario":
		$idedital = $_REQUEST['idedital'];
		$pdo = Database::conexao();
		
		//busca vagas
		$lvg = $pdo->prepare('SELECT * FROM ps_vagas WHERE edital = :idedital');
		$lvg -> bindValue(':idedital', $idedital);
		$lvg -> execute();
		
		//busca edital
		$edt = $pdo->prepare('SELECT * FROM ps_edital WHERE id = :id');
		$edt -> bindValue(':id', $idedital);
		$edt -> execute();
		$r = $edt->fetch(PDO::FETCH_ASSOC);
		$nomeedital = $r['nome'];
		$numedital  = $r['nome'];
		$arquivo = $r['edital'];
		
		$arq = $pdo->prepare('SELECT * FROM ps_arquivos WHERE id_edital = :idedital ORDER BY data ASC');
		$arq -> bindValue(':idedital', $idedital);
		$arq -> execute();
		
		$hoje = date("Y-m-d H:i:s");
		$rec = $pdo->prepare('SELECT * FROM ps_recursos_edital WHERE id_edital = :idedital AND :date >= inicio AND :date <= termino');
		$rec -> bindValue(':idedital', $idedital);
		$rec -> bindValue(':date', $hoje);
		$rec -> execute();
	break;

	case "listarecursos":
		$pdo = Database::conexao();
		/*$stmt = $pdo->prepare('SELECT ps_recursos.nome as nomeRecurso, ps_recursos.etapa, ps_recursos.edital, ps_recursos.cargo, ps_recursos.vaga, ps_recursos.id as idRecurso, ps_edital.id as idEdital, ps_edital.nome as nomeEdital
		FROM ps_recursos, ps_edital 
		WHERE ps_recursos.edital = ps_edital.id');*/
		$stmt = $pdo->prepare('
			SELECT r.id, r.edital, e.nome, e.id as idEdital FROM ps_recursos r, ps_edital e 
			WHERE r.edital = e.id
			GROUP BY e.id
			ORDER BY e.id ASC');
		$stmt -> execute();
	break;

	case "detalhesRec":
		$pdo = Database::conexao();
		$stmt = $pdo->prepare('SELECT * FROM ps_recursos WHERE id = :id');
		$stmt -> bindValue(':id', $_REQUEST['id']);
		$stmt -> execute();
		$r = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt2 = $pdo->prepare('SELECT * FROM ps_recursos_arquivos WHERE id_recurso = :id');
		$stmt2 -> bindValue(':id', $_REQUEST['id']);
		$stmt2->execute();
	break;

	case "arquivosRecurso":
		if(!isset($_SESSION)) session_start();
		$idu = $_SESSION['rgr']['usuarioId'];
		$idrecurso = $_REQUEST['idrecurso'];

		$output_dir =  $_SERVER['DOCUMENT_ROOT'].'/processoseletivo/recursos/'.$idu;
		
		//caso a pasta não exista, cria com as permissões 0755
		if(!file_exists($output_dir) && (!is_dir($output_dir))){
			mkdir($output_dir, 0755);
		}
	
		if(isset($_FILES["myfile"]))
		{
			$ret = array();
			$error =$_FILES["myfile"]["error"];
		   {
				if(!is_array($_FILES["myfile"]['name'])) //single file
				{
					$fileName = uniqid().'-'.$_FILES["myfile"]["name"];
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.'/'.$fileName);
					 //echo "<br> Error: ".$_FILES["myfile"]["error"];
					cadRecurso($fileName, $idu, $idrecurso);
					$ret[$fileName]= $output_dir.$fileName;
				}else{
					$fileCount = count($_FILES["myfile"]['name']);
					
					for($i=0; $i < $fileCount; $i++)
					{
						$fileName = $_FILES["myfile"]["name"][$i];
						$ret[$fileName]= $output_dir.'/'.$fileName;
						move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.'/'.$fileName );
						cadRecurso($fileName, $idu, $idrecurso);
					  }
				}
			}
			echo json_encode($ret);
		}
	break;

	case "frmRecurso":
	
			$idusuario = $_SESSION['rgr']['usuarioId'];
			$pdo = Database::conexao();		

		if($_POST && !empty($_POST['idRecurso'])){
			// se houver envio do formulário, atualiza o registro criado no else abaixo
			$rec = $pdo->prepare('UPDATE ps_recursos SET id_usuario=:idusuario, edital=:edital, cargo=:cargo, vaga=:vaga, email=:email, etapa=:etapa, nome=:nome, justificativa=:justificativa, data = NOW() WHERE id = :idrecurso');
			$rec->bindValue(':idrecurso', $_POST['idRecurso']);
			$rec->bindValue(':idusuario', $idusuario);
			$rec->bindValue(':edital', $_POST['edital']);
			$rec->bindValue(':cargo', $_POST['cargo']);
			$rec->bindValue(':vaga', $_POST['vaga']);
			$rec->bindValue(':email', $_POST['email']);
			$rec->bindValue(':etapa', $_POST['etapa']);
			$rec->bindValue(':nome', $_POST['nome']);
			$rec->bindValue(':justificativa', $_POST['justificativa']);

			if($rec->execute()){
				$classecv = 'ok';
				$avisoCV = 'Recurso registrado!';
			}
		} else {
			//cria um registro no banco sempre que o usuario entrar na pagina, desta forma tenho um id criado e que será utilizado no upload do recurso
			$idedital = $_REQUEST['idEdital'];
			$stmt = $pdo->prepare('SELECT id,nome FROM ps_edital WHERE id = :idedital');
			$stmt -> bindValue(':idedital', $idedital);
			$stmt->execute();
			$edital = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$hoje = date("Y-m-d H:i:s");
			$rec = $pdo->prepare('SELECT * FROM ps_recursos_edital WHERE id_edital = :idedital AND :date >= inicio AND :date <= termino');
			$rec -> bindValue(':idedital', $idedital);
			$rec -> bindValue(':date', $hoje);
			$rec -> execute();
			$etp = $rec->fetch(PDO::FETCH_ASSOC);
			
			$gid = $pdo->prepare('INSERT INTO ps_recursos (id_usuario, edital, cargo, vaga, email, etapa, nome, justificativa, data) VALUES(:idusuario, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NOW())');
			$gid -> bindValue(':idusuario',$idusuario);
			$gid->execute();
			$idd = $pdo->lastInsertId();
		}
	break;

	case "cadEtRecurso":
		$pdo = Database::conexao();
		$stmt = $pdo->prepare('SELECT id,nome FROM ps_edital');
		$stmt -> execute();
	break;

	case "cadEtapaRecurso":
		$pdo = Database::conexao();
		$cad = $pdo->prepare('INSERT INTO ps_recursos_edital (id_edital, nome, inicio, termino) VALUES(:idedital, :nome, :inicio, :termino)');
		$cad -> bindValue(':idedital', $_POST['edital']);
		$cad -> bindValue(':nome', $_POST['etapa']);
		$cad -> bindValue(':inicio', formataDataHora($_POST['inicio'], 'mysql'));
		$cad -> bindValue(':termino', formataDataHora($_POST['termino'], 'mysql'));
		
		echo formataDataHora($_POST['inicio'],'mysql');
		echo formataDataHora($_POST['termino'],'mysql');

		if($cad -> execute()){
			$classecv = 'ok';
			$avisoCV = 'Etapa cadastrada!';
		}
	break;

	case "listaetapas":
		$pdo = Database::conexao();
		$etp = $pdo->prepare('SELECT ps_recursos_edital.*, ps_edital.id as idEdital, ps_edital.nome as nomeEdital FROM ps_recursos_edital, ps_edital WHERE ps_recursos_edital.id_edital = ps_edital.id');
		$etp -> execute();
	break;

	case "excluietapa":
		$idetapa = $_POST['idetapa'];

		$pdo = Database::conexao();
		$stmt = $pdo->prepare('DELETE FROM ps_recursos_edital WHERE id = ?');
		$stmt -> bindParam(1, $idetapa, PDO::PARAM_STR);
		$executa = $stmt -> execute();
			
		if($executa){
			$resposta = array(
				'statusQuery'     => 1,
				'classeResultado' => 'ok',
				'resultadoQuery'  => ' foi apagada com sucesso'
			);
			echo json_encode($resposta);
		}
	break;

	case "editaEtapa":
		$idetapa = $_REQUEST['id'];
		$pdo = Database::conexao();
		$stmt = $pdo->prepare('SELECT ps_recursos_edital.*, ps_edital.id as idEdital, ps_edital.nome as nomeEdital FROM ps_recursos_edital, ps_edital WHERE ps_recursos_edital.id = :idEtapa AND ps_recursos_edital.id_edital = ps_edital.id');
		$stmt ->bindValue(':idEtapa', $idetapa);
		$stmt->execute();
		$r = $stmt->fetch(PDO::FETCH_ASSOC);

		$edt = $pdo->prepare('SELECT id,nome FROM ps_edital');
		$edt -> execute();
	break;

	case "atualizaEtapaRecurso":
		$pdo = Database::conexao();
		$stmt = $pdo->prepare('UPDATE ps_recursos_edital SET nome = :etapa, id_edital = :idedital, inicio = :inicio, termino=:termino WHERE id = :id');
		$stmt -> bindValue(':etapa', $_POST['etapa']);
		$stmt -> bindValue(':idedital', $_POST['edital']);
		$stmt -> bindValue(':inicio', formataDataHora($_POST['inicio'], 'mysql'));
		$stmt -> bindValue(':termino', formataDataHora($_POST['termino'], 'mysql'));
		$stmt -> bindValue(':id', $_POST['idEtapa']);
		
		if($stmt->execute()){
			$classecv = 'ok';
			$avisoCV = 'Etapa atualizada';
		}
	break;

	case "teste":
		$idedital = $_REQUEST['idedital'];
		$pdo = Database::conexao();

		//busca vagas
		$lvg = $pdo->prepare('SELECT * FROM ps_vagas WHERE edital = :idedital ORDER BY numero ASC');
		$lvg -> bindValue(':idedital', $idedital);
		$lvg -> execute();
		
		//busca edital
		$edt = $pdo->prepare('SELECT * FROM ps_edital WHERE id = :id');
		$edt -> bindValue(':id', $idedital);
		$edt -> execute();
		$r = $edt->fetch(PDO::FETCH_ASSOC);
		$nomeedital = $r['nome'];
		$numedital  = $r['nome'];
		$arquivo = $r['edital'];


		$arq = $pdo->prepare('SELECT * FROM ps_arquivos WHERE id_edital = :idedital ORDER BY data ASC');
		$arq -> bindValue(':idedital', $idedital);
		$arq -> execute();
		
		//$hoje = date("Y-m-d H:i:s");
		//$rec = $pdo->prepare('SELECT * FROM ps_recursos_edital WHERE id_edital = :idedital AND :date >= inicio AND :date <= termino');
		$rec = $pdo->prepare('SELECT * FROM ps_recursos_edital WHERE id_edital = :idedital AND NOW() BETWEEN inicio AND termino');
		$rec -> bindValue(':idedital', $idedital);
		//$rec -> bindValue(':date', $hoje);
		$rec -> execute();
		$idusuario = $_SESSION['rgr']['usuarioId'];

		$pdo = Database::conexao();
		$cv = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :usuario');
		$cv -> bindValue(':usuario', $idusuario);
		$cv -> execute();
		$numcv = $cv->rowCount();
	break;

	case "cadInscVest":
		$pdo = Database::conexao();

		$stmt = $pdo->prepare('SELECT id FROM ps_vestibular WHERE cpf = :cpf');
		$stmt ->bindValue(':cpf', $_POST['cpf']);
		$stmt ->execute();
		
		if($stmt -> rowCount() == 0){
			list($erro, $msg, $boletim, $uploaddir) = uploadBoletim();
			
			if($erro == 0){
				$frm = $pdo->prepare('INSERT INTO ps_vestibular (nome, cpf, rg, emissor, dataemissao, pai, mae, nacionalidade, naturalidade, nascimento, sexo, estadocivil, email, comosoube, celular, whatsapp, telcom, telres, 1turno, 2turno, anoconclusao, instituicao, cidadeinstituicao, enem, boletim) VALUES(:nome, :cpf, :rg, :emissor, :dataemissao, :pai, :mae, :nacionalidade, :naturalidade, :nascimento, :sexo, :estadocivil, :email, :comosoube, :celular, :whatsapp, :telcom, :telres, :turno1, :turno2, :anoconclusao, :instituicao, :cidadeinstituicao, :enem, :boletim)');
				$frm->bindValue(':nome',              $_POST['nome']);
				$frm->bindValue(':cpf',               $_POST['cpf']);
				$frm->bindValue(':rg',                $_POST['rg']);
				$frm->bindValue(':emissor',           $_POST['emissor']);
				$frm->bindValue(':dataemissao',       $_POST['dataemissao']);
				$frm->bindValue(':pai',               $_POST['pai']);
				$frm->bindValue(':mae',               $_POST['mae']);
				$frm->bindValue(':nacionalidade',     $_POST['nacionalidade']);
				$frm->bindValue(':naturalidade',      $_POST['naturalidade']);
				$frm->bindValue(':nascimento',        $_POST['nascimento']);
				$frm->bindValue(':sexo',              $_POST['sexo']);
				$frm->bindValue(':estadocivil',       $_POST['estadocivil']);
				$frm->bindValue(':email',             $_POST['email']);
				$frm->bindValue(':comosoube',         $_POST['comosoube']);
				$frm->bindValue(':celular',           $_POST['celular']);
				$frm->bindValue(':whatsapp',          $_POST['whatsapp']);
				$frm->bindValue(':telcom',            $_POST['telcom']);
				$frm->bindValue(':telres',            $_POST['telres']);
				$frm->bindValue(':turno1',             $_POST['turnocurso1']);
				$frm->bindValue(':turno2',             $_POST['turnocurso2']);
				$frm->bindValue(':anoconclusao',      $_POST['anoconclusao']);
				$frm->bindValue(':instituicao',       $_POST['instituicao']);
				$frm->bindValue(':cidadeinstituicao', $_POST['cidadeinstituicao']);
				$frm->bindValue(':enem',              $_POST['enem']);
				$frm->bindValue(':boletim',           $boletim);
				
				if($frm->execute()){
					$classev = 'ok';
					$avisoV  = 'Sua inscrição foi enviada.';
				}
			} else {
				$classev = 'erro';
				$avisoV  = $msg;
			}
		} else {
			$classev = 'erro';
			$avisoV  = 'Já existe uma inscrição para este processo seletivo.';
		}
	break;

	case "listainscritos":
		$pdo = Database::conexao();
		$ins = $pdo -> prepare('SELECT id,nome, cpf, nascimento FROM ps_vestibular');
		$ins -> execute();
		$conta = $ins->rowCount();
	break;

	case "detInscritos":
		$idi = $_REQUEST['id'];
		
		$pdo = Database::conexao();
		$det = $pdo->prepare('SELECT * FROM ps_vestibular WHERE id = :id');
		$det -> bindValue(':id', $idi);
		$det -> execute();
		$r = $det->fetch(PDO::FETCH_ASSOC);
	break;

	case "loginInscricao":
		$cpf   = trim($_POST['cpf']);
		$senha = trim($_POST['senha']);

		if(!empty($cpf) && !empty($senha)){
			$pdo = Database::conexao();
			require_once ('PasswordHash.php');

			try{

				$stmt = $pdo->prepare('SELECT * FROM ps_vestibular_acesso WHERE cpf = ?');
				$stmt -> bindParam(1, $cpf, PDO::PARAM_STR);
				$stmt -> execute();
				$conta = $stmt->rowCount();

				if($conta == 1){
					$res = $stmt->fetch(PDO::FETCH_ASSOC);
					$hash = $res['senha'];
					
					$t_hasher = new PasswordHash(8, FALSE);
					$check = $t_hasher->CheckPassword($senha, $hash);

					if($check){
						if(!isset($_SESSION)){ session_start();} // se a sessão não existir, inicia.
				 
						$_SESSION['rgrv']['usuarioId']    = $res['id'];
						$_SESSION['rgrv']['nivelUsuario'] = 0;
						$_SESSION['rgrv']['emailUsuario'] = $res['email'];
						$_SESSION['rgrv']['cpfUsuario']   = $res['cpf'];
						
						header("Location: https://institutoreger.org.br/vestibular/inscricao.php");
					} else{
							$classev = 'erro';
							$avisoV  = 'O CPF ou senha estão incorretos. Verifique e tente novamente';
					}
				} else {
					$classev = 'erro';
					$avisoV  = 'Verifique os dados informados e tente novamente.';
				}
			} // fim try
			catch(PDOException $e){
				echo $e->getMessage();
			} // fim catch
		} else {
			header("Location: https://institutoreger.org.br/vestibular/index.php");
			exit;
		}
	break;

	case "addUserInscricao":
		require_once ('PasswordHash.php');

		$phpass = new PasswordHash(8, FALSE);
		$hash = $phpass->HashPassword($_POST['addsenha']);

		$pdo = Database::conexao();
		$cv = $pdo->prepare('SELECT * FROM ps_vestibular_acesso WHERE cpf = :cpf');
		$cv -> bindValue(':cpf', $_POST['addcpf']);
		$cv->execute();
		
		if($cv->rowCount() > 0){
			$classev =  'erro';
			$avisoV  = 'O CPF já está cadastrado em nosso sistema!';
		} else {
			$cv3 = $pdo->prepare('INSERT INTO ps_vestibular_acesso (email, senha, cpf) VALUES(:email, :senha, :cpf)');
			$cv3->bindValue(':email', $_POST['addemail']);
			$cv3->bindValue(':senha', $hash);
			$cv3->bindValue(':cpf',   $_POST['addcpf']);
			
			if($cv3->execute()){
				if(!isset($_SESSION)){ session_start();} // se a sessão não existir, inicia.
				$id = $pdo->lastInsertId();
		 
					$_SESSION['rgrv']['usuarioId']    = $id;
				$_SESSION['rgrv']['nivelUsuario'] = '0';
				$_SESSION['rgrv']['emailUsuario'] = $_POST['addemail'];
				$_SESSION['rgrv']['cpfUsuario']   = $_POST['addcpf'];
				header('Location: https://institutoreger.org.br/vestibular/inscricao.php');
			}
		}
	break;

	case "esqueceuSenha":
		$pdo = Database::conexao();
		$rec = $pdo->prepare('SELECT * FROM ps_vestibular_acesso WHERE cpf = :cpf');
		$rec -> bindValue(':cpf', $_POST['novocpf']);
		$rec -> execute();
		
		if($rec->rowCount() > 0){
			$r = $rec->fetch(PDO::FETCH_ASSOC);
			$id = $r['id'];
			$email = $r['email'];
			
			$brs = $pdo->prepare('SELECT * FROM ps_vestibular_recsenha WHERE id_usuario = :id AND cpf = :cpf');
			$brs -> bindValue(':id', $id);
			$brs -> bindValue(':cpf', $_POST['novocpf']);
			$brs -> execute();
			
			if ($brs -> rowCount() != 0){
				$drs = $pdo->prepare('DELETE FROM ps_vestibular_recsenha WHERE id_usuario = :id');
				$drs -> bindValue(':id', $id);
				$drs -> execute();
			}
			
			$chave = sha1(uniqid( mt_rand(), true));
			$novas = $pdo->prepare('INSERT INTO ps_vestibular_recsenha (id_usuario, cpf, hash) VALUES(:id, :cpf, :hash)');
			$novas -> bindValue(':id', $id);
			$novas -> bindValue(':cpf', $_POST['novocpf']);
			$novas -> bindValue(':hash', $chave);
			

			if($novas -> execute()){
				$link = 'https://institutoreger.org.br/vestibular/recuperasenha.php?acao=novaSenhaVest&email='.$email.'&cpf='.$_POST['novocpf'].'&token='.$chave;
				
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: Instituto Reger <naoresponda@institutoreger.org.br';
				
				$msg  = '';
				$msg .= 'Você solicitou a recuperação da senha por e-mail<br>';
				$msg .= 'Clique no link abaixo para criar uma nova senha ou copie e cole no seu navegador<br>';
				$msg .= '<a href="'.$link.'" target="_blank">'.$link.'</a>';

				mail($email, 'Instituto Reger - Recupera Senha', $msg, $headers);
			}
		}

		$classev = 'ok';
		$avisoV  = 'Caso haja um usuário registrado com o CPF informado, você receberá um email com as instruções para alterar sua senha! Lembre-se de verificar a caixa de Spam ou Lixo eletrônico';
	break;

	case "novaSenhaVest":
		$cpf = $_REQUEST['cpf'];
		$token = $_REQUEST['token'];
		$email = $_REQUEST['email'];

		if(empty($cpf) || empty($token)){
			die('Dados incompletos, acesse novamente o link enviado para seu e-mail');
		}else {
			$pdo = Database::conexao();
			$brs = $pdo->prepare('SELECT * FROM ps_vestibular_recsenha WHERE cpf = :cpf AND hash = :token');
			$brs -> bindValue(':cpf', $cpf);
			$brs -> bindValue(':token', $token);
			
			$brs->execute();
			
			if($brs->rowCount() == 1){
				$varrec = '
					<h5 id="txtExp" class="vc text-center">Digite a nova senha nos campos abaixo</h5>
					<form id="novasenhavest" method="post" class="navbar-form navbar-brand" role="form" name="novasenhavest" action="'.$_SERVER['PHP_SELF'].'?acao=novaSenhaRecupera" onsubmit="return validaNovaSenha(this);">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="senha" type="password" class="form-control" name="senha"  placeholder="Senha" required="required" />
						</div>
						
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="senha2" type="password" class="form-control" name="senha2" placeholder="Confirme a senha" required="required" />
						</div>

						<div class="input-group">
							<input type="hidden" name="cpf" value="'.$cpf.'" />
							<input type="hidden" name="email" value="'.$email.'" />
							<input type="hidden" name="token" value="'.$token.'" />
							<input type="submit" class="btn btn-danger form-control" value="Cadastrar nova senha" />
						</div>
					</form>
				';
			} else {
				$varrec = 'Os dados estão incorretos. Utilize o link enviado para o email ou solicite novamente a recuperação de senha';
			}
		}
	break;

	case "novaSenhaRecupera":
		if(!empty($_POST)){
			$cpf = $_POST['cpf'];
			$email = $_POST['email'];
			$token = $_POST['token'];
			
			$pdo = Database::conexao();
			$brs = $pdo->prepare('SELECT * FROM ps_vestibular_recsenha WHERE cpf = :cpf AND hash = :token');
			$brs -> bindValue(':cpf', $cpf);
			$brs -> bindValue(':token', $token);
			
			$brs->execute();
			
			if($brs -> rowCount() == 1){
				
				require_once ('PasswordHash.php');
	
				$phpass = new PasswordHash(8, FALSE);
				$hash = $phpass->HashPassword($_POST['senha']);
	
	
				$stmt = $pdo->prepare('UPDATE ps_vestibular_acesso SET senha = :senha WHERE cpf = :cpf AND email = :email');
				$stmt -> bindValue(':senha', $hash);
				$stmt -> bindValue(':cpf', $cpf);
				$stmt -> bindValue(':email', $_POST['email']);
				if($stmt -> execute()){
					$varrec = 'Sua senha foi atualizada. <a href="index.php">Clique aqui</a> e faça login com seus novos dados de acesso';
				}
				
				$drs = $pdo->prepare('DELETE FROM ps_vestibular_recsenha WHERE cpf = :cpf AND hash = :token');
				$drs -> bindValue(':cpf', $cpf);
				$drs -> bindValue(':token', $token);
				$drs->execute();
			}
		}
	break;

	case "geraPDFInscritos":
		$pdo = Database::conexao();
		$det = $pdo->prepare('SELECT * FROM ps_vestibular');
		$det -> execute();
	break;

	case "testeinfo":
		$id = $_REQUEST['id'];
		
		$pdo = Database::conexao();
		$cv0 = $pdo->prepare('SELECT * FROM cv_usuarios WHERE id = :id');
		$cv0 -> bindValue(':id', $id);
		
		$cv  = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :id');
		$cv -> bindValue(':id', $id);
		
		$cv2  = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :id');
		$cv2 -> bindValue(':id', $id);
		
		$cv3  = $pdo->prepare('SELECT * FROM cv_formacao WHERE id_usuario = :id');
		$cv3 -> bindValue(':id', $id);
		
		$cv4  = $pdo->prepare('SELECT * FROM cv_adicionais WHERE id_usuario = :id');
		$cv4 -> bindValue(':id', $id);
		
		$cv5  = $pdo->prepare('SELECT * FROM cv_experiencia WHERE id_usuario = :id');
		$cv5 -> bindValue(':id', $id);
		
		$cv6 =  $pdo->prepare('SELECT * FROM cv_capacitacao WHERE id_usuario = :id');
		$cv6 -> bindValue(':id', $id);
		
		$cv7 =  $pdo->prepare('SELECT * FROM cv_extras WHERE id_usuario = :id');
		$cv7 -> bindValue(':id', $id);
		
		$cv8 = $pdo->prepare('
		SELECT ps_edital.numero as numEdital, ps_vagas.id as idVg, ps_vagas.numero as numVg, ps_vagas.edital, ps_candidatos.id_usuario, ps_candidatos.datainscricao 
		FROM ps_edital, ps_vagas, ps_candidatos 
		WHERE ps_candidatos.id_usuario = :id AND ps_candidatos.id_vaga = ps_vagas.id AND ps_edital.id = ps_vagas.edital
		');
		$cv8 -> bindValue(':id', $id);


		$cv0 ->execute();
		$cv  ->execute();
		$cv2 ->execute();
		$cv3 ->execute();
		$cv4 ->execute();
		$cv5 ->execute();
		$cv6 ->execute();
		$cv7 ->execute();
		$cv8 ->execute();
		
		$cvm = $cv0 ->fetch(PDO::FETCH_ASSOC);
		$cvp = $cv  ->fetch(PDO::FETCH_ASSOC);
		$cvd = $cv2 ->fetch(PDO::FETCH_ASSOC);
		$cva = $cv4 ->fetch(PDO::FETCH_ASSOC);
		$cvx = $cv7 ->fetch(PDO::FETCH_ASSOC);
	break;

	case "relatorioVagas":
		// c = ps_candidatos
		// e = ps_edital
		// v = ps_vagas
		// idEdital      = ps_edital.id
		// idVaga        = ps_vagas.id
		// nomeEdital    = ps_edital.nome
		// numCandidatos = ps_candidatos.id_vaga
		$idEdital = $_REQUEST['idEdital'];

		$pdo = Database::conexao();
		$con = $pdo->prepare('
			SELECT c.id_vaga, v.local, v.id as idVaga, v.vagas, e.id as idEdital, e.nome as nomeEdital, v.edital, v.cargo, v.numero, COUNT(c.id_vaga) as numCandidatos
			FROM ps_vagas v
			LEFT JOIN ps_candidatos c ON v.id = c.id_vaga
			LEFT JOIN ps_edital e ON v.edital = e.id
			WHERE e.id = :idEdital
			GROUP BY v.numero
			ORDER BY v.numero ASC
		');
		$con -> bindValue(':idEdital', $idEdital);
		$con -> execute();
	break;

	case "buscaRecursos":
		$sql = '
			SELECT r.nome as nomeCandidato, r.vaga, r.cargo, r.etapa, r.edital, r.id as idRecurso, e.id as idEdital, e.nome FROM ps_recursos r, ps_edital e 
			WHERE r.edital = :idedital AND r.edital = e.id 
		';

		if($_POST['etapa'] > 0 && $_POST['etapa'] <=7){
			$sql .= ' AND r.etapa = :etapa';
		}

		$sql .= ' ORDER BY etapa,data DESC';

		$pdo = Database::conexao();
		$rec = $pdo->prepare($sql);
		$rec ->bindValue(':idedital', $_POST['idEdital']);
		
		switch($_POST['etapa']){
			case "1":
				$rec ->bindValue(':etapa', 'Análise Curricular');
			break;
			case "2":
				$rec ->bindValue(':etapa', 'Aula teste');
			break;
			case "3":
				$rec ->bindValue(':etapa', 'Candidatura e triagem');
			break;
			case "4":
				$rec ->bindValue(':etapa', 'Candidatura');
			break;
			case "5":
				$rec ->bindValue(':etapa', 'Aula Prática');
			break;
			case "6":
				$rec ->bindValue(':etapa', 'Dinâmica de Grupo');
			break;
			case "7":
				$rec ->bindValue(':etapa', 'Entrevista');
			break;
		}
		
		if($rec -> execute()){
			if($rec->rowCount() > 0){
				echo "<table class='table table-bordered'>";
				echo "<thead><th>Nome</th><th>Etapa</th><th>Cargo</th><th class='text-center'>Vaga</th><th></th></thead>";
				echo "<tbody>";
				while($r = $rec->fetch(PDO::FETCH_ASSOC)){
					echo "
					<tr>
					<td>".$r['nomeCandidato']."</td>
					<td>".$r['etapa']."</td>
					<td>".$r['cargo']."</td>
					<td class='text-center'>".$r['vaga']."</td>
					<td class='text-center'><a href='detalhesRecurso.php?id=".$r['idRecurso']."' class='btn btn-danger vb' target='_blank'>Ver mais detalhes</a></td>
					</tr>
					";
				}
				echo "<tbody>";
				echo "</table>";
			}else {
				echo "Não há recursos cadastrados para esta etapa.";
			}
		}else {
			echo "Ocorreu um erro ao buscar os recursos.";
		}
	break;

	case "geraPdfCv":
		$id = $_REQUEST['id'];
		
		$pdo = Database::conexao();
		$cv = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :usuario');
		$cv -> bindValue(':usuario', $id);
		$cv -> execute();
		$numcv = $cv->rowCount();

		if($id == $_SESSION['rgr']['usuarioId']){
			$cv0 = $pdo->prepare('SELECT * FROM cv_usuarios WHERE id = :id');
			$cv0 -> bindValue(':id', $id);

			$cv1 = $pdo->prepare('SELECT * FROM cv_pessoais WHERE id_usuario = :id');
			$cv1 -> bindValue(':id', $id);

			$cv2 = $pdo->prepare('SELECT * FROM cv_documentos WHERE id_usuario = :id');
			$cv2 -> bindValue(':id', $id);

			$cv3 = $pdo->prepare('SELECT * FROM cv_formacao WHERE id_usuario = :id');
			$cv3 -> bindValue(':id', $id);

			$cv4 = $pdo->prepare('SELECT * FROM cv_adicionais WHERE id_usuario = :id');
			$cv4 -> bindValue(':id', $id);

			$cv5 = $pdo->prepare('SELECT * FROM cv_experiencia WHERE id_usuario = :id');
			$cv5 -> bindValue(':id', $id);

			$cv6 = $pdo->prepare('SELECT * FROM cv_capacitacao WHERE id_usuario = :id');
			$cv6 -> bindValue(':id', $id);

			$cv7 = $pdo->prepare('SELECT * FROM cv_extras WHERE id_usuario = :id');
			$cv7 -> bindValue(':id', $id);

			$cv8 = $pdo->prepare('
			SELECT ps_edital.numero as numEdital, ps_vagas.numero as numVg, ps_vagas.edital, ps_candidatos.id_usuario, ps_candidatos.datainscricao 
			FROM ps_edital, ps_vagas, ps_candidatos 
			WHERE ps_candidatos.id_usuario = :id AND ps_candidatos.id_vaga = ps_vagas.id AND ps_edital.id = ps_vagas.edital
			');
			$cv8 -> bindValue(':id', $id);

			$cv0 ->execute();
			$cv1 ->execute();
			$cv2 ->execute();
			$cv3 ->execute();
			$cv4 ->execute();
			$cv5 ->execute();
			$cv6 ->execute();
			$cv7 ->execute();
			$cv8 ->execute();
			
			$cvm = $cv0 ->fetch(PDO::FETCH_ASSOC);
			$cvp = $cv1 ->fetch(PDO::FETCH_ASSOC);
			$cvd = $cv2 ->fetch(PDO::FETCH_ASSOC);
			
			$cva = $cv4 ->fetch(PDO::FETCH_ASSOC);
			$cvx = $cv7 ->fetch(PDO::FETCH_ASSOC);
		} else {
			$erro = 'Ocorreu um erro ao gerar o currículo. Tente novamente através do menu "Currículo > Gerar currículo"';
		}
	break;

	case "importaCsv":
		if(($_POST) && $_POST['inserirVG'] == 'Sim'){
				$csv = $_FILES['csvfile']['tmp_name'];

		        if (($handle = fopen($csv, "r")) !== FALSE) {

		        	$linhaCsv = 1;
		        	$arrayLinha = array();

        		    while (($data = fgetcsv($handle, 2000, "\n")) !== FALSE) {

	                	$num = count($data);

	                	for ($c=0; $c < $num; $c++) {
		                    $dados = $data[$c];
		                    $d = explode(';',$dados);

		                    // verifica se a linha possui mais ou menos que 11 itens. Se sim, houve erro no preenchimento da planilha.
		                    // os erros mais comuns são caracteres ; ou quebra de linha (alt+enter) dentro do conteúdo de uma célula
		                    // cada quebra de linha é considerada fim de uma linha na planilha
		                    // e cada ; é considerado como delimitador de uma célula

							if(count($d) == 9) {

								$pdo = Database::conexao();
								$ins = $pdo->prepare('
									INSERT INTO ps_vagas (cargo, local, atribuicoes, formacao, vagas, carga, turno, salario, numero, edital)
									VALUES (:cargo, :local, :atribuicoes, :formacao, :vagas, :carga, :turno, :salario, :numero, :edital)
								');

								$ins->bindValue(':cargo',utf8_encode($d[0]));
								$ins->bindValue(':local',utf8_encode($d[1]));
								$ins->bindValue(':atribuicoes',utf8_encode($d[2]));
								$ins->bindValue(':formacao',utf8_encode($d[3]));
								$ins->bindValue(':vagas',utf8_encode($d[4]));
								$ins->bindValue(':carga',utf8_encode($d[5]));
								$ins->bindValue(':turno',utf8_encode($d[6]));
								$ins->bindValue(':salario',utf8_encode($d[7]));
								$ins->bindValue(':numero',utf8_encode($d[8]));
								$ins->bindValue(':edital',$_POST['edital']);

								if($ins->execute()){
									$msg = 'As vagas foram importadas para o banco de dados.';
								}
							} else {
								$arrayLinha[] = $linhaCsv;
							}
	                	}
	            	$linhaCsv++;
	            	}
    	        	fclose($handle);
				}
		}
	break;

	case "excluiInscricao":
		//antes de excluir o registro, buscamos pelo id_usuario e id_vaga na tabela de inscrições, caso haja apenas um registro, fará a exclusão
		$idUsuario = $_POST['id_usuario'];
		$idVaga = $_POST['id_vaga'];

		$pdo = Database::conexao();
		$res = $pdo->prepare('SELECT * FROM ps_candidatos WHERE id_vaga = :idvaga AND id_usuario = :idusuario');
		$res -> bindValue(':idvaga', $idVaga);
		$res -> bindValue(':idusuario', $idUsuario);
		$res -> execute();

		if($res->rowCount() == 1){
			// se houver apenas um resultado com os dados informados, prossegue para a exclusão da inscrição
			$del = $pdo->prepare('DELETE FROM ps_candidatos WHERE id_vaga = :idvaga AND id_usuario = :idusuario');
			$del -> bindValue(':idvaga', $idVaga);
			$del -> bindValue(':idusuario', $idUsuario);
			
			if($del -> execute()){
				$resposta = array(
					'statusQuery'     => 1,
					'classeResultado' => 'alert-success',
					'resultadoQuery'  => ' foi apagada com sucesso'
				);
			} else {
				$resposta = array(
					'statusQuery'    => 0,
					'classResultado' => 'alert-danger',
					'resultadoQuery' => 'Ocorreu um erro e a inscrição não pode ser excluída'
				);
			}
			echo json_encode($resposta);
		}
	break;

	case "uploadComprovante":
		$output_dir = '../pdf/comprovante/'.$_SESSION['rgr']['usuarioId'].'/';

		//caso a pasta não exista, cria com as permissões 0755
		if(!file_exists($output_dir) && (!is_dir($output_dir))){
			mkdir($output_dir, 0755);
		}
		
		if(isset($_FILES["myfile"])){
			$ret = array();
		
			$error =$_FILES["myfile"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData()
			$extensao = strtolower(pathinfo($_FILES["myfile"]["name"],PATHINFO_EXTENSION)); // obtém a extensão do arquivo

			if(!is_array($_FILES["myfile"]["name"])) {
				$data = date('dmY-His');
				$fileName = $_POST['campo'].uniqid().'-'.$data.'.'.$extensao;

	 			move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
	    		$ret[]= $fileName;
			}
			else {
				$fileCount = count($_FILES["myfile"]["name"]);
	
				for($i=0; $i < $fileCount; $i++){
	  				$fileName = uniqid().$_FILES["myfile"]["name"][$i];
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  				$ret[]= $fileName;
	  			}
			}
    	echo json_encode($ret);
 		}
 	break;

 	case "buscaComprovante":
 		$dir = '../pdf/comprovante/'.$_SESSION['rgr']['usuarioId'];

 		if (file_exists($dir) && is_dir($dir)) {
 			$files = scandir($dir);
 		
 			$ret= array();
 			foreach($files as $file)
 			{
	
				if($file == "." || $file == ".." || strpos($file, 'comprovante') === false)
 				continue;
 	
 				$filePath=REGER.'/pdf/comprovante/'.$_SESSION['rgr']['usuarioId']."/".$file;
 				$details = array();
 				$details['name']=$file;
 				$details['path']=$filePath;
 				$details['size']=filesize($filePath);
 				$ret[] = $details;
 			}
 		echo json_encode($ret);

	 	}
 	break;

 	case "downloadComprovante":
 	$campo = $_GET['campo'];
 	
 	$path = REGER.'/pdf/comprovante/'.$_SESSION['rgr']['usuarioId'];
 	
 	$fileName=$_GET['filename'];
 	$fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
 	$file = $path.'/'.$fileName;
 	$file = str_replace("..","",$file);
 	$fileName =str_replace(" ","",$fileName);
 	header('Content-Description: File Transfer');
 	header('Content-Disposition: attachment; filename='.$fileName);
 	header('Content-Transfer-Encoding: binary');
 	header('Expires: 0');
 	header('Cache-Control: must-revalidate');
 	header('Pragma: public');
 	header('Content-Length: ' . filesize($file));
 	ob_clean();
 	flush();
 	readfile($file);
 	exit;

break;

case "deletaComprovante":

	$output_dir = '../pdf/comprovante/'.$_SESSION['rgr']['usuarioId'];
	if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
	{
		$fileName = $_POST['name'];
		$fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files	
		$filePath = $output_dir.'/'.$fileName;
		if (file_exists($filePath)) 
		{
	        unlink($filePath);
	    }
		echo "Arquivo deletado ".$fileName."<br>";
	}
break;
}
$pdo= NULL; // LIMPA A CONEXAO COM O BANCO

?>