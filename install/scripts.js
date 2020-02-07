function step1()
{
	$("#info").html("");
	var realmlist = document.getElementById("step1_realmlist").value;
	var title = document.getElementById("step1_title").value;
	var host = document.getElementById("step1_host").value;
	var user = document.getElementById("step1_user").value;
	var pass = document.getElementById("step1_pass").value;
	var webdb = document.getElementById("step1_webdb").value;
	var worlddb = document.getElementById("step1_worlddb").value;
	var logondb = document.getElementById("step1_logondb").value;
	var email = document.getElementById("step1_email").value;
	var domain = document.getElementById("step1_domain").value;
	var expansion = document.getElementById("step1_exp").value;
	var paypal = document.getElementById("step1_paypal").value;
	
	$.post("functions.php", { step: 1, realmlist: realmlist, title: title, host: host, user: user, pass:pass, webdb: webdb, worlddb: worlddb, logondb: logondb,
	email: email, domain: domain, expansion: expansion, paypal: paypal },
       function(data) 
	   {
          if(data==true) {
			 window.location="?st=2";
		  } else {
			 $("#info").html("<p><code>" + data + "</code></p>");
		  }
   });
}

function step2()
{
	$("#info").html("");
	$.post("functions.php", { step: 2},
       function(data) 
	   {
          $("#info").html("<p><code>" + data + "</code></p>");
   });
	
}

function step3()
{
	$("#info").html("");
	$.post("functions.php", { step: 3},
       function(data) 
	   {
          $("#info").html("<p><code>" + data + "</code></p>");
   });
	
}

function step4()
{
	$("#info").html("");
	$.post("functions.php", { step: 4},
       function(data) 
	   {
          $("#info").html("<p><code>" + data + "</code></p>");
   });
	
}

function step5()
{
	var rid = document.getElementById("addrealm_id").value;
	var name = document.getElementById("addrealm_name").value;
	var host = document.getElementById("addrealm_host").value;
	var port = document.getElementById("addrealm_port").value;
	var desc = document.getElementById("addrealm_desc").value;
	var m_host = document.getElementById("addrealm_m_host").value;
	var m_user = document.getElementById("addrealm_m_user").value;
	var m_pass = document.getElementById("addrealm_m_pass").value;
	var a_user = document.getElementById("addrealm_a_user").value;
	var a_pass = document.getElementById("addrealm_a_pass").value;
	var sendtype = document.getElementById("addrealm_sendtype").value;
	var chardb = document.getElementById("addrealm_chardb").value;
	var raport = document.getElementById("addrealm_raport").value;
	var soapport = document.getElementById("addrealm_soapport").value;
	
	if(soapport == "")
	{
		soapport = "NULL";
	}
	if(raport == "")
	{
		raport = "NULL";
	}
	
	$.post("functions.php", { step: 5, rid: rid, name: name, host: host, port: port, desc: desc, m_host: m_host, m_user: m_user, m_pass: m_pass,
	a_user: a_user, a_pass: a_pass, sendtype: sendtype, chardb: chardb, raport: raport, soapport: soapport },
       function(data) 
	   {
          if(data==true) {
			 window.location="?st=6";
		  } else {
			 $("#info").html("<p><code>" + data + "</code></p>");
		  }
   });
}