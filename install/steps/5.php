<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<p id="steps"><b>Introdução</b> &raquo; Informações MySQL &raquo; Configurar &raquo; Banco de Dados &raquo; <b>Informações do Reino</b> &raquo; Fim<p>
<hr/>
    <fieldset style="height: 445px;">
        <legend>Configurações do Reino</legend>
        <label>Host do Reino</label><BR />
        <input type="text" placeholder="127.0.0.1" id="addrealm_host"><BR />
        <label>Porta do Reino</label><BR />
        <input type="text" placeholder="8085" id="addrealm_port"><BR />
        <label>ID do Reino</label><BR /></label>
        <input type="text" placeholder="1" id="addrealm_id"><BR />
        <label>Nome do Reino</label><BR />
        <input type="text" placeholder="Reino Simples" id="addrealm_name"><BR />
        <label>Descrição do Reino (opcional)</label><BR />
        <input type="text" placeholder="Blizzlike 3x" id="addrealm_desc"><BR />
        <label>Host do MySQL</label><BR />
        <input type="text" placeholder="127.0.0.1" id="addrealm_m_host"><BR />
        <label>Usuário do MySQL</label><BR />
        <input type="text" placeholder="root" id="addrealm_m_user"><BR />
        <label>Senha do MySQL</label><BR />
        <input type="text" placeholder="ascent" id="addrealm_m_pass"><BR />
        <label>Banco de Dados dos Personagens</label><BR />
        <input type="text" placeholder="characters" id="addrealm_chardb"><BR />
    </fieldset>
    <BR />
    <fieldset>
      <legend>Configurações Remotas</legend>
        <legend>
<label>Usuário da Conta Administradora</label><BR />
        <input type="text" placeholder="admin" id="addrealm_a_user"><BR />
        <label>Senha da Conta Administradora</label><BR />
        <input type="text" placeholder="admin" id="addrealm_a_pass"><BR />

        <label>Console Remoto</label><BR />
        <select id="addrealm_sendtype">
        <option value="ra">RA</option>
        <option value="soap">SOAP</option>
        </select><BR />

        <label>Porta RA (Ignorar se você tiver escolhido a opção SOAP)</label><BR />
        <input type="text" placeholder="3443" id="addrealm_raport"><BR />
        <label>Porta SOAP (Ignorar se você tiver escolhido a opção RA)</label><BR />
        <input type="text" placeholder="7878" id="addrealm_soapport"><BR />
        </legend>
    </fieldset>
    <BR />
    <input type="submit" value="Finalizar" onclick="step5()">