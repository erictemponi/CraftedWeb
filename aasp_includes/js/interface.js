$("input[type='text']").not(document.getElementsByClassName('noremove')).focus(function() {
	this.value="";
});
$("input[type='password']").focus(function() {
	this.value="";
});

document.onkeydown = function(event) 
{
	var key_press = String.fromCharCode(event.keyCode);
	var key_code = event.keyCode;
	if(key_code == 27)
		{
			hideLoader();
		}
}


function showLoader() {
	centerLoader();
	$("#overlay").fadeIn("fast");
	$("#loading").fadeIn("slow");
}

function hideLoader() {
	$("#overlay").fadeOut("fast");
	$("#loading").fadeOut("fast");
	$("#loading").html("Carregando...");
}

function centerLoader() {

    var scrolledX = document.body.scrollLeft || document.documentElement.scrollLeft || self.pageXOffset;
    var scrolledY = document.body.scrollTop || document.documentElement.scrollTop || self.pageYOffset;
	

    var screenWidth = document.body.clientWidth || document.documentElement.clientWidth || self.innerWidth;
    var screenHeight = document.body.clientHeight || document.documentElement.clientHeight || self.innerHeight;

    var left = scrolledX + (screenWidth - $("#loading").width())/2;
    var top = scrolledY + (screenHeight - $("#loading").height())/4;
    //centering
    $("#loading").css({
        "position": "absolute",
        "top": top,
        "left": left
    });
	
	
	$("#overlay").click(function(){
         $("#loading").fadeOut();
		 $("#overlay").fadeOut();	
	});
}

function getPage(pagename) {
	$(".box_right").html("<img src='images/ajax-loader.gif'>'");
	$(".box_right").load("pages/" + pagename + ".php");
}

function loader(id) {
	$(id).html("<img src='styles/default/images/ajax-loader.gif'>'");
}
function templateInstallGuide() {
	showLoader();
	$("#loading").html("<h3>Instalando Modelos</h3>\
	<h4>Etapa 1</h4>Primeiro de tudo, baixe ou crie um modelo para o CraftedWeb. Se você tem experiência em HTML/CSS, você deve ser capaz de criar um, usando como base o modelo\
	padrão. Se você não dá conta de fazer, precisa arrumar o modelo de algum lugar.\
	<h4>Etapa 2</h4>Pegue a pasta onde está o modelo que você quer instalar. O nome da pasta é indiferente, mas deve ser uma pasta, não ZIP ou RAR, etc.\
	Coloque a pasta dentro da pasta /styles/ que se encontra na pasta raiz onde você instalou o CraftedWeb.\
	<h4>Etapa 3</h4>Entre no Painel do Administrador, navegue até Interface->Modelo. Seção 'Instalar um novo modelo'. No primeiro campo, coloque o nome da pasta que contém o seu\ modelo. No segundo campo, coloque um nome indicativo para o modelo.\
	<h4>Etapa 4</h4>Volte ao Painel do Administrador, Interface->Modelo. Agora na seção 'Escolha o Modelo', escolha o nome do seu modelo e clique em 'Salvar'.\
	<h4>Pronto!</h4>O seu template deve ser instalado e ativado no seu site. Você pode desativar isso a hora que quiser, e ativar também. <br/>\
	<i>Para desenvolvedores de modelos:</i> Após a instalação de um modelo, não é necessário instalá-lo novamente. Apenas altere o que quiser, se quiser.<br/>\
	<input type='submit' value='Entendi!' onclick='hideLoader()'>");
}

function setTemplate() {
	var id = document.getElementById("choose_template").value;
	
	showLoader();
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/layout.php", { action: "setTemplate", id: id },
       function(data) {
			window.location='?p=interface'
   });
   
}

function installTemplate() {
	
	var path = document.getElementById("installtemplate_path").value;
	var name = document.getElementById("installtemplate_name").value;
	
	showLoader();
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/layout.php", { action: "installTemplate", path: path,name: name },
       function(data) {
			window.location='?p=interface'
   });
	
}

function uninstallTemplate() {
	
	var id = document.getElementById("uninstall_template_id").value;
	
	showLoader();
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/layout.php", { action: "uninstallTemplate", id:id },
       function(data) {
			window.location='?p=interface'
   });
	
}

function editMenu(id) {
	
	showLoader();
	$.post("../aasp_includes/scripts/layout.php", { action: "getMenuEditForm", id:id },
       function(data) {
			$("#loading").html(data);
   });
	
}

function saveMenuLink(pos) {
	
	var title = document.getElementById("editlink_title").value;
	var url = document.getElementById("editlink_url").value;
	var shownWhen = document.getElementById("editlink_shownWhen").value;
	
	showLoader();
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/layout.php", { action: "saveMenu", title: title, url: url, shownWhen: shownWhen, id: pos },
       function(data) {
			 if(data==true) {
			window.location='?p=interface&s=menu'
		   } else {
			 $("#loading").html(data);  
		   }
   });
   
}

function deleteLink(id) {
	
	showLoader();
	$("#loading").html("Tem certeza de que deseja excluir este link?<br/><br/>\
	<input type='submit' value='Sim' onclick='deleteLinkNow( " + id + " )'> <input type='submit' value='Não' onclick='hideLoader()'>");
	
}

function deleteLinkNow(id) {
	
	showLoader();
	$("#loading").html("Salvando...");
	$.post("../aasp_includes/scripts/layout.php", { action: "deleteLink", id: id },
       function(data) {
			 if(data==true) {
			window.location='?p=interface&s=menu'
		   } else {
			 $("#loading").html(data);  
		   }
   });
   
}

function addLink() {
	
	showLoader();
	$("#loading").html("<h3>Adicionar Link</h3>\
	Título<br/><input type='text' id='addlink_title'><br/>\
	URL<br/><input type='text' id='addlink_url'><br/>\
	Exibir quando<br/><select id='addlink_shownWhen'>\
	<option value='always'>Sempre</option><option value='logged'>Logado</option>\
	<option value='notlogged'>Não logado</option>\
	</select><br/>\
	<input type='submit' value='Adicionar' onclick='addLinkNow()'>");
	
}

function addLinkNow() {
	
	var title = document.getElementById("addlink_title").value;
	var url = document.getElementById("addlink_url").value;
	var shownWhen = document.getElementById("addlink_shownWhen").value;
	
	$("#loading").html("Adicionando...");
	
	$.post("../aasp_includes/scripts/layout.php", { action: "addLink", title: title, url: url, shownWhen: shownWhen },
       function(data) {
		   if(data==true) {
			   window.location='?p=interface&s=menu'
		   } else {
			    $("#loading").html(data);  
		   }
   });
	
}

$("#menu_left ul li").not("#menu_head").click(function() {
	if($(this).next().is(":hidden")) {
			 $(this).next().slideDown("slow");
		} else {
          $(this).next().slideUp("slow");
		}
});

function savePage(filename) {

	var action = document.getElementById("action-" + filename).value;

	if(action==2 || action==1) {
		$.post("../aasp_includes/scripts/pages.php", { action: "toggle", value: action, filename: filename },
       function(data) {
			 window.location='?p=pages';
       });
	}
	
	if(action==3) {
		
		window.location='?p=pages&action=edit&filename=' + filename;
		
	}
	
	if(action==4) {
		showLoader();
		$("#loading").html('Tem certeza de que deseja excluir esta página?<br/>\
		<input type="submit" value="Sim" onclick="deletePage(\'' + filename +  '\')"> \
		<input type="submit" value="Não" onclick="hideLoader()">');
	}
	
}

function deletePage(filename) {
	$.post("../aasp_includes/scripts/pages.php", { action: "delete", filename: filename },
       function(data) {
			 window.location='?p=pages';
       });
}

function removeSlideImage(id) {
	showLoader();
	$("#loading").html('Tem certeza de que deseja remover esta imagem?<br/>\
	<input type="submit" value="Sim" onclick="removeSlideImageNow('+ id +')"> \
	<input type="submit" value="Não" onclick="hideLoader()">');
}

function removeSlideImageNow(id) {
	$.post("../aasp_includes/scripts/layout.php", { action: "deleteImage", id: id },
       function(data) {
			 window.location='?p=interface&s=slideshow';
       });
}

function addSlideImage() {
	$("#addSlideImage").fadeIn(500);
}

function editVoteLink(id,title,points,image,url) {
	showLoader();
	$("#loading").html('Título<br/><input type="text" value="'+title+'" id="editVoteLink_title"><br/>\
	Pontos<br/><input type="text" value="'+points+'" id="editVoteLink_points"><br/>\
	URL da imagem<br/><input type="text" value="'+image+'" id="editVoteLink_image"><br/>\
	URL<br/><input type="text" value="'+url+'" id="editVoteLink_url"><br/>\
	<input type="submit" value="Salvar" onclick="saveVoteLink('+id+')"> <input type="submit" value="Fechar" onclick="hideLoader()">');
}

function saveVoteLink(id) {
	var title = document.getElementById("editVoteLink_title").value;
	var points = document.getElementById("editVoteLink_points").value;
	var image = document.getElementById("editVoteLink_image").value;
	var url = document.getElementById("editVoteLink_url").value;
	
	$.post("../aasp_includes/scripts/pages.php", { action: "saveVoteLink", id: id, title:title, points:points, image:image, url:url },
       function(data) {
			 window.location='?p=services&s=voting';
       });
}

function removeVoteLink(id) {
	showLoader();
	$("#loading").html('Tem certeza de que deseja remover este site de votação?<br/>\
	<input type="submit" value="Sim" onclick="removeVoteLinkNow('+ id +')"> \
	<input type="submit" value="Não" onclick="hideLoader()">');
}

function removeVoteLinkNow(id) {
	$.post("../aasp_includes/scripts/pages.php", { action: "removeVoteLink", id: id },
       function(data) {
			 window.location='?p=services&s=voting';
       });
}

function addVoteLink() {
	showLoader();
	$("#loading").html('Título<br/><input type="text" id="addVoteLink_title"><br/>\
	Pontos<br/><input type="text" id="addVoteLink_points"><br/>\
	URL da imagem<br/><input type="text" id="addVoteLink_image"><br/>\
	URL<br/><input type="text" id="addVoteLink_url"><br/>\
	<input type="submit" value="Adicionar" onclick="addVoteLinkNow()"> <input type="submit" value="Fechar" onclick="hideLoader()">');
}

function addVoteLinkNow() {
	var title = document.getElementById("addVoteLink_title").value;
	var points = document.getElementById("addVoteLink_points").value;
	var image = document.getElementById("addVoteLink_image").value;
	var url = document.getElementById("addVoteLink_url").value;
	
	   $.post("../aasp_includes/scripts/pages.php", { action: "addVoteLink", title:title, points:points, image:image, url:url },
       function(data) {
			 window.location='?p=services&s=voting';
       });
}

function saveServicePrice(service) {
	var price = document.getElementById(service + "_price").value;
	var currency = document.getElementById(service + "_currency").value;
	var enabled = document.getElementById(service + "_enabled").value;
	
	
	$.post("../aasp_includes/scripts/pages.php", { action: "saveServicePrice", service:service, price: price, currency: currency, enabled: enabled },
       function(data) {
			 window.location='?p=services&s=charservice';
       });
}

function disablePlugin(foldername) {
	
	$.post("../aasp_includes/scripts/layout.php", { action: "disablePlugin", foldername: foldername},
       function(data) {
			 window.location='?p=interface&s=viewplugin&plugin=' + foldername;
       });
}

function enablePlugin(foldername) {
	
	$.post("../aasp_includes/scripts/layout.php", { action: "enablePlugin", foldername: foldername},
       function(data) {
			 window.location='?p=interface&s=viewplugin&plugin=' + foldername;
       });
}