function test_settings() {
	
	showLoader();
	
	$.post("../aasp_includes/scripts/test_settings.php", { test: true  },
       function(data) {
			 $("#loading").html(data + "<br/><a href='#' onclick='hideLoader()'>Fechar</a>");
   });
   
}

function edit_realm(id,name,host,port,chardb) {
	
	showLoader();
	
	$("#loading").html("ID<br/><input type='text' id='editrealm_newid' value='"+ id +"'>\
	<br/>Nome<br/><input type='text' id='editrealm_name' value='"+ name +"'>\
	<br/>Host<br/><input type='text' id='editrealm_host' value='"+ host +"'>\
	<br/>Porta<br/><input type='text' id='editrealm_port' value='"+ port +"'>\
	<br/>BD dos Personagens<br/><input type='text' id='editrealm_chardb' value='"+ chardb +"'>\
	<br/><input type='submit' value='Salvar' onclick='edit_realmNow("+ id +")'>");
	
}

function edit_realmNow(id) {
	
	var new_id = document.getElementById('editrealm_newid').value;
	var name = document.getElementById('editrealm_name').value;
	var host = document.getElementById('editrealm_host').value;
	var port = document.getElementById('editrealm_port').value;
	var chardb = document.getElementById('editrealm_chardb').value;
	
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/realms.php", { action: "edit", id: id, name: name, host: host, port: port, chardb: chardb,new_id: new_id },
       function(data) {
			window.location='?p=realms&s=manage'
   });
}

function delete_realm(id,name) {
	
	$("#loading").html("Tem certeza de que deseja excluir <b>" + name + "</b><br/>\
	<input type='submit' value='Sim' onclick='delete_realmNow("+ id +")'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
	showLoader();
	
}

function delete_realmNow(id) {
	
	$("#loading").html("Excluindo...");
	
	$.post("../aasp_includes/scripts/realms.php", { action: "delete", id: id },
       function(data) {
			window.location='?p=realms&s=manage'
   });
}

function edit_console(id,type,user,pass) {
	
	showLoader();
	
	if(type=="ra") {
		typeInput = "<select id='console_type'>\
		<option value='ra' selected='selected'>RA</option>\
		<option value='soap'>SOAP</option>\
		</select>";
	} else if(type=="soap") {
		typeInput = "<select id='console_type'>\
		<option value='ra'>RA</option>\
		<option value='soap' selected='selected'>SOAP</option>\
		</select>";
	}
	
	$("#loading").html("Tipo de console<br/> " + typeInput + "\
	<br/>Usuário<br/><input type='text' id='console_rank_user' value='"+ user +"'>\
	<br/>Senha<br/><input type='text' id='console_rank_pass' value='"+ pass +"'>\
	<br/><input type='submit' value='Salvar' onclick='edit_consoleNow("+ id +")'>\
	<br/><br/><i>O usuário precisa ter permissões de MJ para usar o comando '.send mail'.</i>");
	
}

function edit_consoleNow(id) {
	
	var type = document.getElementById("console_type").value;
	var user = document.getElementById("console_rank_user").value;
	var pass = document.getElementById("console_rank_pass").value;
	
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/realms.php", { action: "edit_console", id: id, type: type, user: user, pass:pass },
       function(data) {
			window.location='?p=realms&s=manage'
   });
	
}

function loadTickets() {
	var offline = "Off";
	var realm = document.getElementById("tickets_realm").value;
	
	if ($("#tickets_offline").is(':checked')) { 
	  offline = "on";
	 }
	
	$("#tickets").html("Carregando...");
	
	$.post("../aasp_includes/scripts/realms.php", { action: "loadTickets", offline:offline, realm:realm },
       function(data) {
			$("#tickets").html(data);
   });
}

function deleteTicket(id,db) {
	$("#loading").html("Tem certeza de que deseja excluir a consulta de ID: "+id+" <br/>\
	<input type='submit' value='Sim' onclick='deleteTicketNow("+ id + ", \"" + db +  "\")'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
	showLoader();
}

function deleteTicketNow(id,db) {
	$("#loading").html("Excluindo...");
	
	$.post("../aasp_includes/scripts/realms.php", { action: "deleteTicket", id: id, db:db },
       function(data) {
		 hideLoader();
		 loadTickets();
   });
}

function closeTicket(id,db) {
	$("#loading").html("Tem certeza de que deseja fechar a consulta de ID: "+id+" <br/>\
	<input type='submit' value='Sim' onclick='closeTicketNow("+ id + ", \"" + db +  "\")'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
	showLoader();
}

function closeTicketNow(id,db) {
	$("#loading").html("Fechando...");
	
	$.post("../aasp_includes/scripts/realms.php", { action: "closeTicket", id: id, db:db },
       function(data) {
		 hideLoader();
		 loadTickets();
   });
}

function openTicket(id,db) {
	$("#loading").html("Tem certeza de que deseja abrir a consulta de ID: "+id+" <br/>\
	<input type='submit' value='Sim' onclick='openTicketNow("+ id + ", \"" + db +  "\")'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
	showLoader();
}

function openTicketNow(id,db) {
	$("#loading").html("Fechando...");
	
	$.post("../aasp_includes/scripts/realms.php", { action: "openTicket", id: id, db:db },
       function(data) {
		 hideLoader();
		 loadTickets();
   });
}

function characterListActions(guid,realmid) {
	$("#loading").html("Ações disponíveis<br/>\
	<input type='submit' value='Ver inventário' onclick='window.location=\"?p=users&s=inventory&guid="+guid+"&rid="+realmid+"&f=equip\"'> \
	<input type='submit' value='Editar personagem' onclick='window.location=\"?p=users&s=viewchar&guid="+guid+"&rid="+realmid+"\"'><br/>\
	<input type='submit' value='Fechar' onclick='hideLoader()'>");
	
	showLoader();
}

function changePresetRealmStatus()
{
	$("#loading").html("Carregando reinos...");
	
	showLoader();
	
	$.post("../aasp_includes/scripts/realms.php", { action: "getPresetRealms" },
       function(data) {
		 $("#loading").html(data);
   });
}

function savePresetRealm(rid)
{
	$("#loading").html("Salvando...");
	
	$.post("../aasp_includes/scripts/realms.php", { action: "savePresetRealm", rid: rid },
       function(data) {
		 window.location.reload();
   });
}
