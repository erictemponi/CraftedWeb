<?php 
    session_start();
	$step = (int)$_GET['st']; 
	$steps = array(
	1 => 'Conexão com o Banco de Dados e Informações Gerais',
	2 => 'Arquivo de Configuração',
	3 => 'Criar Banco de Dados e Preencher o Arquivo de Configuração',
	4 => 'Atualizações',
	5 => 'Adicionando seu primeiro Reino',
	6 => 'Fim');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<title>Instalação do CW</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="install.css" type="text/css" media="screen" />
</head>
<body>
<center>
<div id="main_box">
	<h1>Instalação &raquo; Etapa <?php echo $step; ?> (<?php echo $steps[$step]; ?>)</h1>

	<div id="content">
    	<?php include( './steps/' . $step . '.php' )?>
        
        <div id="info">
        	
        </div>
	</div>
</div>
&copy 2020 <a href="http://fury-games.boards.net/" target="_blank">Fury Games</a>
</center>
</body>
</html>
<script type="text/javascript" src="scripts.js"></script>