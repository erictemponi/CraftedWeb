<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
    <p id="steps">Introdução &raquo; <b>Informações MySQL</b> &raquo; Configurar &raquo; Banco de Dados &raquo; Informações do Reino &raquo; Fim<p>
    <hr/>
    <fieldset style="float: left;">
		<legend>Configurações do MySQL</legend>
		<label>Host do MySQL</label><BR />
        <input type="text" placeholder="127.0.0.1" id="step1_host"><BR />
		<label>Porta do MySQL</label><BR />
		<input type="text" placeholder="3306" id="step1_port"><BR />
        <label>Usuário do MySQL</label><BR />
        <input type="text" placeholder="root" id="step1_user"><BR />
        <label>Senha do MySQL</label><BR />
        <input type="text" placeholder="ascent" id="step1_pass"><BR />
        <label>Banco de Dados do Site</label><BR />
        <input type="text" placeholder="site" id="step1_webdb"><BR />
        <label>Banco de Dados das Contas</label><BR />
        <input type="text" placeholder="auth" id="step1_logondb"><BR />
        <label>Banco de Dados do Mundo</label><BR />
        <input type="text" placeholder="world" id="step1_worlddb"><BR />
    </fieldset>

    <fieldset style="float: right;">
		<legend>Configurações do Site e do Servidor</legend>
		<label>Expansão do Core</label><BR />
        <select id="step1_exp">
            <option value="0">Vanilla (Sem expansão)</option>
            <option value="1">The Burning Crusade</option>
            <option value="2" selected>Wrath of the Lich King (TrinityCore)</option>
            <option value="3">Cataclysm (SkyfireEMU)</option>
            <option value="4">Mists of Pandaria</option>
        </select><BR />
        <label>Realmlist</label><BR />
        <input type="text" placeholder="seuserver.servegame.com" id="step1_realmlist"><BR />
        <label>Domínio do Site</label><BR />
        <input type="text" placeholder="http://seuserver.com" id="step1_domain"><BR />
        <label>Tìtulo do Site</label><BR />
        <input type="text" placeholder="SeuServer" id="step1_title"><BR />
        <label>E-mail do PayPal</label><BR />
        <input type="text" placeholder="seuemail@gmail.com" id="step1_paypal"><BR />
        <label>E-mail Padrão</label><BR />
		<input type="text" placeholder="seuserver@seuserver.com" id="step1_email">
    </fieldset>
    <BR><BR />
    <input type="submit" value="Vá Para a Etapa 2" onclick="step1()">