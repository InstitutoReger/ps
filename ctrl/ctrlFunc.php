<?
function apagaSessao(){
	if(isset($_SESSION['rgr'])){
		//apaga as informações da sessao
		unset($_SESSION['rgr']['usuarioId']);
		unset($_SESSION['rgr']['nivelUsuario']);
		unset($_SESSION['rgr']['emailUsuario']);
	}

	//destroi a sessao
	session_destroy();
	session_write_close();
}

function verificaLogado(){
	if(!isset($_SESSION['rgr']['usuarioId'])) { // se o código do usuário não for encontrado na sessão redireciona para a página de login e destroi a sessão
		apagaSessao();
		header("Location: https://".$_SERVER['SERVER_NAME']."/index.php"); exit;
	} else{
		return true;
	}
}

function verificaLogadoVest(){
	if(!isset($_SESSION['rgrv']['usuarioId'])) { // se o código do usuário não for encontrado na sessão redireciona para a página de login e destroi a sessão
		apagaSessao();
		header("Location: https://".$_SERVER['SERVER_NAME']."/vestibular/index.php"); exit;
	} else{
		return true;
	}
}

function formataData($dataInput, $destino){
	//pega a data do campo no formato pt-br e transforma para o formato do mysql
	if($destino == 'mysql'){
		$data = explode('/', $dataInput);
		$dia = $data['0'];
		$mes = $data['1'];
		$ano = $data['2'];
		$datafinal = $ano.'-'.$mes.'-'.$dia;

		if ($datafinal == '--'){
			$datafinal = '0000-00-00';
		}
	}

	//pega a data do mysql e transforma para o formato pt-br
	if($destino == 'php'){
		$data = explode('-', $dataInput);
		$dia = $data['2'];
		$mes = $data['1'];
		$ano = $data['0'];
		$datafinal = $dia.'/'.$mes.'/'.$ano;
	}
	return $datafinal;
}

function formataDataHora($data, $destino){
	$dados = explode(' ', $data);
	$data = $dados[0];
	$hora = $dados[1];
	$datafinal = formataData($data,$destino);

	if($destino == 'mysql'){
		$horafinal = $hora;
	}

	if($destino == 'php'){
		$hora = explode(':', $hora);
		$horafinal = $hora[0].':'.$hora[1];
	}

	$datafield = $datafinal.' '.$horafinal;
	return $datafield;
}

function formataDataHora2($data, $destino){
	$dados = explode(' ', $data);
	$data = $dados[0];
	$hora = $dados[1];
	$datafinal = formataData($data,$destino);

	if($destino == 'mysql'){
		$horafinal = $hora.':00';
	}

	if($destino == 'php'){
		$hora = explode(':', $hora);
		$horafinal = $hora[0].':'.$hora[1].':'.$hora[2];
	}

	$datafield = $datafinal.' '.$horafinal;
	return $datafield;
}



function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

function verificaNivelUser(){
	$idUsuario = $_SESSION['rgr']['usuarioId'];
	$pdo = Database::conexao();
	$stmt = $pdo->prepare('SELECT cod_nivel FROM cv_usuarios WHERE id = ? LIMIT 1');
	$stmt -> bindParam(1, $idUsuario, PDO::PARAM_STR);
	$stmt->execute();
	
	if($stmt->rowCount() == 1){
		$r = $stmt->fetch(PDO::FETCH_ASSOC);
		$nUsuario = $r['cod_nivel'];
	}

	if($nUsuario == '999'){
		return true;
	}else{
		return false;
	}

	$nUsuario = '';	
}

function verificaInscricao($idPs){
	$idUsuario = $_SESSION['rgr']['usuarioId'];

	$pdo = Database::conexao();
	$vin = $pdo->prepare('SELECT * FROM ps_candidatos WHERE id_usuario = :idUsuario AND id_vaga = :idVaga');
	$vin -> bindValue(':idUsuario', $idUsuario);
	$vin -> bindValue(':idVaga', $idPs);
	$vin -> execute();

	if($vin->rowCount() > 0){
		return true;
	}
}


function buscaDetCv($idcv){
	$pdo = Database::conexao();
	$det = $pdo->prepare('SELECT nome, nascimento FROM cv_pessoais WHERE id_usuario = :idcv');
	$det2 = $pdo->prepare('SELECT nome_curso FROM cv_formacao WHERE id_usuario = :idcv2');
	$det -> bindValue(':idcv', $idcv);
	$det2 -> bindValue(':idcv2', $idcv);
	$det -> execute();
	$det2 -> execute();
	$r = $det->fetch(PDO::FETCH_ASSOC);
	$r2 = $det2->fetch(PDO::FETCH_ASSOC);

	echo '
			<tr>
				<td>'.$r['nome'].'</td>
				<td>'.$r2['nome_curso'].'</td>
				<td>'.formataData($r['nascimento'], 'php').'</td>
				<td><a href="visualizacv.php?idCV='.$idcv.'" target="_blank" class="btn btn-default vb" style="color:#fff">Ver mais</a></td>
			</tr>
	';
}

function uploadMaterial(){
	$pdf     = $_FILES['edital']['name']; // nome
	$tmpdir  = $_FILES['edital']['tmp_name']; //diretorio temporario
	$pdfsize = $_FILES['edital']['size']; // tamanho
		
	//diretório base
	$uploaddir = REGER.'/pdf/';

	//diretório de cada disciplina
	$unDir  = strtolower(tirarAcentos($uploaddir));

	$pdfext    = strtolower(pathinfo($pdf,PATHINFO_EXTENSION)); // obtém a extensão do arquivo

	$extensoes = array('PDF','pdf'); // extensões permitidas

	$nomeunico       = $_POST['nomevaga'].'-'.uniqid();
	$nomeSemEspaco   = str_replace(' ', '-', $nomeunico);
	$nomeSemAcentos  = tirarAcentos($nomeSemEspaco);
	$nomeSemCaracEsp = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $nomeSemAcentos)); //remove caracteres especiais do nome
	$nomeFinal       = $nomeSemCaracEsp.".".$pdfext;

	if(!empty($pdf)){
		if(in_array($pdfext, $extensoes)){
			if($pdfsize < 25000000){
				//move o arquivo para o diretório e depois cria o zip
				move_uploaded_file($tmpdir,$uploaddir.$nomeFinal);
				chmod($uploaddir.$nomeFinal, 0644);

				$erro = 0;
			}else {
				$erro = 1;
				$msg = "O pdf possui tamanho maior que o permitido. Tamanho máximo permitido: 25mb";
			}

		} else {
			$erro = 1;
			$msg = "Formato inválido! Formatos permitidos: pdf";
		}
	}else {
		$erro = 2; // caso o usuário não tenha definido nova foto
	}

	return array ($erro, $msg, $nomeFinal, $uploaddir);
}


function buscainfoCv($id){
	$pdo = Database::conexao();
	$cvd = $pdo->prepare('
	SELECT cv_pessoais.nome, cv_pessoais.nascimento, cv_formacao.nome_curso
	FROM cv_pessoais INNER JOIN cv_formacao
	ON cv_pessoais.id_usuario = cv_formacao.id_usuario
	WHERE cv_pessoais.id_usuario = :id AND cv_formacao.id_usuario = :id2');
	$cvd -> bindValue(':id', $id);
	$cvd -> bindValue(':id2', $id);
	$cvd -> execute();

	while($dados = $cvd->fetch(PDO::FETCH_ASSOC)){
		echo '<tr class="listvg">';
			echo '<td class="cvNome">'.$dados['nome'].'</td>';
			echo '<td class="cvCurso">'.$dados['nome_curso'].'</td>';
			echo '<td class="cvNascimento">'.formataData($dados['nascimento'], 'php').'</td>';
			echo '<td class="cvDetalhes">';
			echo '<a href="visualizacv.php?idCV='.$id.'" target="_blank" class="btn btn-default vb">Ver mais</a></td>';
		echo '</tr>';
	}
}

function listaEditais($edital){
	$pdo = Database::conexao();
	$edt = $pdo->prepare('SELECT * FROM ps_edital');
	$edt -> execute();

	echo '<select name="edital" class="form-control">';

	while($e = $edt->fetch(PDO::FETCH_ASSOC)){
		if ($e['id'] == $edital){ $ed = "selected";} else {$ed='';}
		echo '<option value="'.$e['id'].'" '.$ed.'>'.$e['nome'].'</option>';
	}
	echo '</select>';
}

function buscaEdital($idedital){
	$pdo = Database::conexao();
	$edt = $pdo->prepare('SELECT * FROM ps_edital WHERE id = :idedital');
	$edt -> bindValue(':idedital', $idedital);
	$edt -> execute();
	$edi = $edt->fetch(PDO::FETCH_ASSOC);

	$link = $edi['edital'];
	echo '<a href="pdf/'.$link.'" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a>';
}



function numVagasEdital($tiponum, $id){
	$pdo = Database::conexao();
	$vg = $pdo->prepare('SELECT vagas FROM ps_vagas WHERE edital = :idedital');
	$vg -> bindValue(':idedital', $id);
	$vg -> execute();

	if($tiponum == 'vagas'){
		while($v = $vg->fetch(PDO::FETCH_ASSOC)){
			$numvg = $numvg + $v['vagas'];
		}
		if($numvg === 0){
			$numvg = 'Cadastro de Reserva';
		}
		echo $numvg;
	}

	
	if($tiponum == 'cargos'){
		echo $vg -> rowCount();
	}
}



function nomeEdital($id){
	$pdo = Database::conexao();
	$vg = $pdo->prepare('SELECT nome FROM ps_edital WHERE id = :idedital');
	$vg -> bindValue(':idedital', $id);
	$vg -> execute();

	$edt = $vg->fetch(PDO::FETCH_ASSOC);
	$nomeedital = $edt['nome'];

	echo $nomeedital;
}


function cadRecurso($file, $id, $idr){
	$pdo = Database::conexao();
	$cad = $pdo->prepare('INSERT INTO ps_recursos_arquivos (id_recurso, arquivo) VALUES(:id, :arquivo)');
	$cad -> bindValue(':id', $idr);
	$cad -> bindValue(':arquivo', $id.'/'.$file);
	$cad -> execute();
}


//faz upload do boletim do enem
function uploadBoletim(){
	$pdf     = $_FILES['boletim']['name']; // nome
	$tmpdir  = $_FILES['boletim']['tmp_name']; //diretorio temporario
	$pdfsize = $_FILES['boletim']['size']; // tamanho
		
	//diretório base
	$uploaddir = REGER.'/pdf/boletim/';

	//diretório de cada disciplina
	$unDir  = strtolower(tirarAcentos($uploaddir));
	$pdfext    = strtolower(pathinfo($pdf,PATHINFO_EXTENSION)); // obtém a extensão do arquivo
	$extensoes = array('PDF','pdf'); // extensões permitidas

	$cpf = str_replace('.', '', $_POST['cpf']);
	$cpf = str_replace('-', '', $cpf);
	$nomeunico = $cpf.'-'.uniqid().".".$pdfext;

	if(!empty($pdf)){
		if(in_array($pdfext, $extensoes)){
			if($pdfsize < 30000000){
				//move o arquivo para o diretório e depois cria o zip
				move_uploaded_file($tmpdir,$uploaddir.$nomeunico);
				chmod($uploaddir.$nomeunico, 0644);
				$erro = 0;
			}else {
				$erro = 1;
				$msg = "O pdf possui tamanho maior que o permitido. Tamanho máximo permitido: 25mb";
			}
		} else {
			$erro = 1;
			$msg = "Formato inválido! Formatos permitidos: pdf";
		}
	}else {
		$erro = 2; // caso o usuário não tenha definido nova foto
	}

	return array ($erro, $msg, $nomeunico, $uploaddir);
}



function mask_email( $email, $mask_char, $percent ){ 
	list( $user, $domain ) = preg_split("/@/", $email ); 

    $len = strlen( $user ); 
    $mask_count = floor( $len * $percent /100 ); 
    $offset = floor( ( $len - $mask_count ) / 2 ); 
    $masked = substr( $user, 0, $offset ) 
              .str_repeat( $mask_char, $mask_count ) 
              .substr( $user, $mask_count+$offset ); 

	return( $masked.'@'.$domain );
	//echo mask_email( 'bobbyjones@gmail.com', '*', 80 ); 
} 

//envia email para o usuário com a confirmação da inscrição
function envia_confirmacao_email($idusuario, $idvaga){

	$pdo = Database::conexao();
	$consultainfo = $pdo->prepare('
		SELECT v.id as idVaga, v.edital, v.cargo, v.numero, v.local, v.carga, v.turno, v.formacao, 
		e.nome as nomeEdital, e.id as idEdital, p.id_usuario, p.nome as nomeUsuario, u.id, u.email
		FROM ps_vagas v, ps_edital e, cv_pessoais p, cv_usuarios u
		WHERE v.id = :idvaga
		AND p.id_usuario = :idusuario
		AND v.edital = e.id
		AND u.id = :idusuario
		LIMIT 1
	');
	$consultainfo->bindValue(':idvaga',$idvaga);
	$consultainfo->bindValue(':idusuario',$idusuario);
	
	if($consultainfo->execute()){
		$c = $consultainfo->fetch(PDO::FETCH_ASSOC);

		$emailsender = "naoresponda@institutoreger.com.br";
		$headers  = "MIME-Version: 1.1\n";
		$headers .= "Content-type: text/html; charset=UTF-8\n";
		$headers .= "From: Instituto Reger <naoresponda@institutoreger.com.br>\n"; // remetente
		$headers .= "Return-Path: naoresponda@institutoreger.com.br\n"; // return-path

		$msgConfirm  = "";
		$msgConfirm .= "<h3>Sua inscrição foi realizada!</h3><br>";
		$msgConfirm .= "Confira abaixo as informações da sua inscrição: <br>";
		$msgConfirm .= "<b>Nome:</b> ".$c['nomeUsuario']."<br>";
		$msgConfirm .= "<b>Email:</b> ".$c['email']."<br>";
		$msgConfirm .= "<b>Edital:</b> ".$c['nomeEdital']."<br>";
		$msgConfirm .= "<b>Cargo:</b> ".$c['cargo']."<br>";
		$msgConfirm .= "<b>Número da vaga:</b> ".$c['numero']."<br>";
		$msgConfirm .= "<b>Local:</b> ".$c['local']."<br>";
		$msgConfirm .= "<b>Carga horária:</b> ".$c['carga']."<br>";
		$msgConfirm .= "<b>Turno:</b> ".$c['turno']."<br>";
		$msgConfirm .= "<b>Formação: </b>".$c['formacao'];

		if(!mail($c['email'], 'Instituto Reger - Confirmação de inscrição', $msgConfirm, $headers ,"-r".$emailsender)){ // Se for Postfix
			mail($c['email'], 'Instituto Reger - Confirmação de inscrição', $msgConfirm, $headers );
		}
	}
}


//salva o id do usuário e da vaga antes de excluir o currículo/inscrição
function grava_exclusao($id){

	$pdo = Database::conexao();
	$save = $pdo->prepare('SELECT * FROM ps_candidatos WHERE id_usuario = :idusuario');
	$save-> bindValue(':idusuario', $id);

	if($save->execute()){
		//nome do arquivo de texto
		$arquivo = 'log_exc_cv.txt';
		//abre o arquivo com permissão somente para gravação
		$abre = fopen($arquivo,'a');

		while($f = $save->fetch(PDO::FETCH_ASSOC)){
			// conteúdo da linha
			$conteudo = 'id_usuario => '.$f['id_usuario'].', id_vaga => '.$f['id_vaga'].', datainscricao => '.$f['datainscricao'].', dataexclusao => '.date("d/m/Y H:i:s").PHP_EOL;
			
			// grava o conteúdo no arquivo
			fwrite($abre, $conteudo);
		}

		//fecha o arquivo
		fclose($abre);
	}
}
?>