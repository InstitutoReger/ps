<?
$acaolocal = 'detInscritos';
include('ctrl/ctrlSite.php');
if(!isset($_SESSION)) session_start();
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
		<h1 class="text-center">Detalhes do inscrito(a)</h1>

		<strong>Nome</strong>: <?=$r['nome'];?><br />
		<strong>CPF</strong>: <?=$r['cpf'];?><br />
		<strong>RG</strong>: <?=$r['rg'];?><br />
		<strong>Emissor</strong>: <?=$r['emissor'];?><br />
		<strong>Data emissão:</strong>: <?=$r['dataemissao'];?><br />
		<strong>Pai</strong>: <?=$r['pai'];?><br />
		<strong>Mãe</strong>: <?=$r['mae'];?><br />
		<strong>Nacionalidade: </strong> <?=$r['nacionalidade'];?><br />
		<strong>Naturalidade: </strong> <?=$r['naturalidade'];?><br />
		<strong>Nascimento: </strong> <?=$r['nascimento'];?><br />
		<strong>Sexo:</strong> <?=$r['sexo'];?><br />
		<strong>Estado Civil:</strong> <?=$r['estadocivil'];?><br />
		<strong>Email: </strong> <?=$r['email'];?><br />
		<strong>Como soube: </strong> <?=$r['comosoube'];?><br />
		<strong>Celular: </strong> <?=$r['celular'];?><br />
		<strong>WhatsApp:</strong> <?=$r['whatsapp'];?><br />
		<strong>Telefone comercial:</strong> <?=$r['telcom'];?><br />
		<strong>Telefone residencial:</strong> <?=$r['telres'];?><br />
		<strong>1ª opção de turno:</strong> <?=$r['1turno'];?><br />
		<strong>2ª opção de turno:</strong> <?=$r['2turno'];?><br />
		<strong>Ano de conclusão do ensino médio:</strong> <?=$r['anoconclusao'];?><br />
		<strong>Instituição:</strong> <?=$r['instituicao'];?><br />
		<strong>Cidade da Instituição:</strong> <?=$r['cidadeinstituicao'];?><br />
		<strong>Ano que realizou o ENEM:</strong> <?=$r['enem'];?><br />
		<strong><a href="http://institutoreger.com.br/pdf/boletim/<?=$r['boletim'];?>" target="_blank">Visualizar boletim do ENEM</a></strong>

    </div>
</div>
<? } else {?>
		<? header('Location: index.php');?>
<? } ?>
</body>
</html>