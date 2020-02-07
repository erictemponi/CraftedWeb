<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<p id="steps">Introdução &raquo; Informações MySQL &raquo; <b>Configurar</b> &raquo; Banco de Dados &raquo; Informações do Reino &raquo; Fim<p>
<hr/>
<p>Agora precisamos verificar se podemos escrever no Arquivo de Configuração. Antes de verificar, certifique-se de que:</p>
<p>O CHMOD está definido para 777 nos arquivos <i>'includes/configuration.php'</i> e <i>'install/sql/CraftedWeb_Base.sql'</i></p>
<br />
    (Você <b>deve</b> alterar o CHMOD de ambos de volta para 664 após terminar o processo de instalação!)<br />
    O arquivo <b>deve</b> existir. Não estamos criando um novo arquivo, estamos apenas escrevendo sobre um já existente que está em branco. Se o arquivo (includes/configuration.php) não existir, crie-o. Você pode fazer isso usando o Bloco de Notas ou<br />
    outro software parecido. Lembre-se de salvá-lo como <i>configuration.php</i>, NÃO .TXT!</p>
    <p>
	<br/>
	<input type="submit" value="Continuar" onclick="step2()">
</p>