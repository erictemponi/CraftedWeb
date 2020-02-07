<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

?>
<?php 
define('INIT_SITE', TRUE);
require('configuration.php'); 

if($GLOBALS['useDebug']==false)
	exit();
?>

<h2>Registros de erros</h2>

<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=clear" title="Clear the entire log">Limpar registros</a>
<hr/>

<?php
if (isset($_GET['action']) && $_GET['action']=='clear') 
{
	$errFile = '../error.log';
	$fh = fopen($errFile, 'w') or die("Não é possível abrir o arquivo");
	$stringData = "";
	fwrite($fh, $stringData);
	fclose($fh);
  ?>
  	<meta http-equiv="Atualizar" content="0; url=<?php echo $_SERVER['PHP_SELF']; ?>">
  <?php
}
if(!$file = file_get_contents('../error.log')) {
  echo 'O script não encontrou nenhuma informação sobre o erro. Arquivo de registro.';
}

echo str_replace('*','<br/>',$file);

?>