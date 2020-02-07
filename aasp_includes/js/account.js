function login(panel) 
{
	var username = document.getElementById("login_username").value;
	var password = document.getElementById("login_password").value;
	
	showLoader();
	
	$.post("../aasp_includes/scripts/login.php", { login: true, username: username, password: password, panel: panel },
       function(data) {
          if(data==true) {
			 window.location="index.php";
		  } else {
			 $("#login_status").html(data); 
		  }
		  hideLoader();
   });
}

function save_account_data() 
{
	var email = document.getElementById("edit_email").value;
	var password = document.getElementById("edit_password").value;
	var vp = document.getElementById("edit_vp").value;
	var dp = document.getElementById("edit_dp").value;
	var id = document.getElementById("account_id").value;
	
	showLoader();
	
	$.post("../aasp_includes/scripts/account.php", { action: 'edit', email: email, password: password, vp: vp, dp: dp,id: id},
       function(data) {
			 $("#loading").html(data); 
   });
}

function editAccA(id,rank,realm) 
{
	$("#loading").html("Ranque <br/>\
	<input type='text' value='"+rank+"' id='editAccARank'><br/>\
	ID do Reino<br/>\
	<input type='text' value='"+realm+"' id='editAccARealm'><br/>\
	<input type='submit' value='Salvar' onclick='editAccANow("+id+")'>");
	
	showLoader();
}

function editAccANow(id) 
{
	var rank = document.getElementById("editAccARank").value;
	var realm = document.getElementById("editAccARealm").value;
	
	$("#loading").html("Salvando...");

	$.post("../aasp_includes/scripts/account.php", { action: "saveAccA", id: id, rank: rank, realm: realm},
       function(data) {
		 window.location='?p=tools&s=accountaccess';
   });
}

function removeAccA(id) 
{
	$("#loading").html("Tem certeza de que deseja remover os privilégios de MJ desta conta? <br/>\
	<input type='submit' value='Sim' onclick='removeAccANow(" + id + ")'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
	showLoader();
}

function removeAccANow(id) 
{
	
	$("#loading").html("Removendo...");

	$.post("../aasp_includes/scripts/account.php", { action: "removeAccA", id: id},
       function(data) {
		 window.location='?p=tools&s=accountaccess';
   });
}

function addAccA() 
{
	$("#loading").html("Nome de usuário <br/>\
	<input type='text' id='addAccAUser'><br/>\
	Ranque<br/>\
	<input type='text' value='3' id='addAccARank'><br/>\
	ID do Reino (-1 = Todos os reinos)<br/>\
	<input type='text' value='-1' id='addAccARealm'><br/>\
	<input type='submit' value='Adicionar' onclick='addAccANow()'>");
	
	showLoader();
}

function addAccANow() 
{
	var user = document.getElementById("addAccAUser").value;
	var rank = document.getElementById("addAccARank").value;
	var realm = document.getElementById("addAccARealm").value;
	
	$.post("../aasp_includes/scripts/account.php", { action: "addAccA", user: user, rank:rank, realm: realm},
       function(data) {
		 window.location='?p=tools&s=accountaccess';
   });
}

function editChar(guid,rid)
{
	$("#loading").html("Tem certeza de que deseja salvar este personagem? <br/>\
	<input type='submit' value='Sim' onclick='editCharNow("+ guid + "," + rid + ")'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
	showLoader();
}

function editCharNow(guid,rid)
{
	$("#loading").html("Salvando...");
	showLoader();
	
	var charname = document.getElementById("editchar_name").value;
	var account = document.getElementById("editchar_accname").value;
	var raceid = document.getElementById("editchar_race").value;
	var classid = document.getElementById("editchar_class").value;
	var genderid = document.getElementById("editchar_gender").value;
	var money = document.getElementById("editchar_money").value;
	
	
	$.post("../aasp_includes/scripts/account.php", { 
	action: "editChar", guid: guid, rid: rid, name: charname, account: account, race: raceid, class: classid, gender: genderid, money: money},
       function(data) {
		 $("#loading").html(data);
   });
}
