<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<meta name="robots" content="noindex">
<title>Instituto Reger</title>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.mask.min.js"></script>
<script type="text/javascript" src="js/bootbox.min.js"></script>

<script type="text/javascript" src="js/buscacep.js"></script>
<script type="text/javascript" src="js/printthis.js"></script>

<? echo '<script type="text/javascript" src="js/rgr.js?' . date("YmdHis", filemtime("js/rgr.js")) . '"></script>'; ?>
<? echo '<script type="text/javascript" src="js/jquery.bootstrap.wizard.min.js?' . date("YmdHis", filemtime("js/jquery.bootstrap.wizard.min.js")) . '"></script>'; ?>
<? echo '<script type="text/javascript" src="js/cvvalidation.js?' . date("YmdHis", filemtime("js/cvvalidation.js")) . '"></script>'; ?>
<? echo '<script type="text/javascript" src="js/confirm.js?' . date("YmdHis", filemtime("js/confirm.js")) . '"></script>'; ?>

<? echo '<link href="css/bootstrap.min.css?' . date("YmdHis", filemtime("css/bootstrap.min.css")) . '" type="text/css" rel="stylesheet" />'; ?>
<? echo '<link href="css/reger.css?' . date("YmdHis", filemtime("css/reger.css")) . '" type="text/css" rel="stylesheet" />'; ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="css/uploadfile.css" rel="stylesheet">
<script src="js/uploader.js"></script>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
<script type="text/javascript">
$('#inicio').mask('00/00/0000');
$('#termino').mask('00/00/0000');
$('#nascimento').mask('00/00/0000');
$('#dataconcextra1').mask('00/00/0000');
$('#dataconcextra2').mask('00/00/0000');
$('#dataconcextra3').mask('00/00/0000');
$('#dataconcextra4').mask('00/00/0000');
$('#dataconcextra5').mask('00/00/0000');
$('#datainicio1').mask('00/00/0000');
$('#datasaida1').mask('00/00/0000');
$('#datainicio2').mask('00/00/0000');
$('#datasaida2').mask('00/00/0000');
$('#conclusao1').mask('00/0000');
$('#conclusao2').mask('00/0000');
$('#inicioEdital').mask('00/00/0000');
$('#terminoEdital').mask('00/00/0000');
</script>

<script>
  $( function() {
    $( ".datepicker" ).datepicker({
  dateFormat: "dd/mm/yy",
  changeMonth: true,
  changeYear: true,
  dayNames: [ "Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado" ],
  dayNamesMin  : ["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
  dayNamesShort : ["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
  monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
  monthNamesShort: [ "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez" ],
  yearRange: '1940:2019',
});
  } );
  </script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-104423366-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>