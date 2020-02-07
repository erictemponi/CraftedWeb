<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<div class="box_right_title">Atualizações</div>
<script type="text/javascript">
function getLatestVersions() {
	$(".hidden_version").fadeIn("fast");
}
</script>
<table width="100%">
       <tr>
            <td>Versão atual: r_01</td>
            <td class="hidden_version">Versão disponível: r_02</td>
       </tr>
       <tr>
            <td>Versão atual do Banco de Dados: r_01</td>
            <td class="hidden_version">Versão disponível do Banco de Dados: r_02</td>
       </tr>
       <tr>
           <td><input type="submit" value="Verificar se há novas atualizações" onclick="getLatestVersions()"/></td>
           <td class="hidden_version"><input type="submit" value="Atualizar" onclick="alert('Hehe, Pegadinha do Malandro. Este recurso ainda não foi implementado! :D')"/></td>
       </tr>
</table>