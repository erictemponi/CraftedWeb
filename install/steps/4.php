<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<p id="steps"><b>Introdução</b> &raquo; Informações MySQL &raquo; Configurar &raquo; <b>Banco de Dados</b> &raquo; Informações do Reino &raquo; Fim<p>
<hr/>
<p>
	Após verificar sua pasta de atualização, encontramos as seguintes atualizações para o Banco de Dados: 
    <ul>
    	<?php
			$files = scandir('sql/updates/');
			foreach($files as $value) {
				if(substr($value,-3,3)=='sql')
				{
					echo '<a href="#">'.$value.'</a><br/>';	
					$found = true;
				}
			}
		?>
    </ul>
    <?php
	if(!isset($found))
				echo '<code>Nenhuma atualização foi encontrada na sua pasta de atualizações. <a href="?st=5">Clique aqui para continuar</a></code>';
	?>
    <i>* Dica: Clique sobre elas para obter mais informações.</i>
</p>
<p> Clique no botão abaixo para aplicar todas essas atualizações. Se você não deseja aplicar essas
<br />
atualizações, basta clicar <a href="?st=5">aqui</a>. Você poderá instalá-las sempre que quiser manualmente<br />
inserindo-os em seu Banco de Dados com qualquer software de Banco de Dados. (HeidiSQL, SQLyog, etc.)</p>
<p>
	<br/>
	<input type="submit" value="Instalar Atualizações" onclick="step4()">
</p>