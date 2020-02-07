function addSingleItem() {
	var entry = document.getElementById('addsingle_entry').value;
	var price = document.getElementById('addsingle_price').value;
	var shop = document.getElementById('addsingle_shop').value;
	
	showLoader();
	
	$.post("../aasp_includes/scripts/shop.php", { action: 'addsingle',entry: entry, price: price, shop: shop},
       function(data) {
          $("#loading").html(data);
   }); 
}

function addMultiItem() {
	var il_from = document.getElementById('addmulti_il_from').value;
	var il_to = document.getElementById('addmulti_il_to').value;
	var quality = document.getElementById('addmulti_quality').value;
	var price = document.getElementById('addmulti_price').value;
	var shop = document.getElementById('addmulti_shop').value;
	var type = document.getElementById('addmulti_type').value;
	
	showLoader();
	
	$.post("../aasp_includes/scripts/shop.php", { action: 'addmulti',il_from: il_from,il_to:il_to, price: price, shop: shop,
	quality: quality, type: type},
       function(data) {
          $("#loading").html(data);
   }); 
}

function modSingleItem() {
	var entry = document.getElementById('modsingle_entry').value;
	var price = document.getElementById('modsingle_price').value;
	var shop = document.getElementById('modsingle_shop').value;
	
	showLoader();
	
	$.post("../aasp_includes/scripts/shop.php", { action: 'modsingle',entry: entry, price: price, shop: shop},
       function(data) {
          $("#loading").html(data);
   }); 
}

function modMultiItem() {
	var il_from = document.getElementById('modmulti_il_from').value;
	var il_to = document.getElementById('modmulti_il_to').value;
	var quality = document.getElementById('modmulti_quality').value;
	var price = document.getElementById('modmulti_price').value;
	var shop = document.getElementById('modmulti_shop').value;
	var type = document.getElementById('modmulti_type').value;
	
	showLoader();
	
	$.post("../aasp_includes/scripts/shop.php", { action: 'modmulti',il_from: il_from,il_to:il_to, price: price, shop: shop,
	quality: quality, type: type},
       function(data) {
          $("#loading").html(data);
   }); 
}

function delSingleItem() {
	var entry = document.getElementById('modsingle_entry').value;
	var shop = document.getElementById('modsingle_shop').value;
	
	$("#loading").html('Tem certeza de que deseja remover este item da loja?<br/>\
	<input type="submit" value="Sim" onclick="delSingleItemNow('+entry+',\''+shop+'\')"> <input type="submit" value="Não" onclick="hideLoader()">');
	
	showLoader();
}

function delSingleItemNow(entry,shop) {
	$.post("../aasp_includes/scripts/shop.php", { action: 'delsingle',entry: entry, shop: shop},
       function(data) {
          $("#loading").html(data);
   }); 
}

function delMultiItem() {
	var il_from = document.getElementById('modmulti_il_from').value;
	var il_to = document.getElementById('modmulti_il_to').value;
	var quality = document.getElementById('modmulti_quality').value;
	var shop = document.getElementById('modmulti_shop').value;
	var type = document.getElementById('modmulti_type').value;
	
	$("#loading").html('Tem certeza de que deseja remover todos estes itens da loja?<br/>\
	<input type="submit" value="Sim" onclick="delMultiItemNow(\''+il_from+'\',\''+il_to+'\',\''+quality+'\',\''+shop+'\',\''+type+'\')"> \
	<input type="submit" value="Não" onclick="hideLoader()">');
	
	showLoader();
}


function delMultiItemNow(il_from,il_to,quality,shop,type) {
	
	showLoader();
	
	$.post("../aasp_includes/scripts/shop.php", { action: 'delmulti',il_from: il_from,il_to:il_to, shop: shop,
	quality: quality, type: type},
       function(data) {
          $("#loading").html(data);
   }); 
}

function clearShop(shop) {
	showLoader();
	
	<!-- Remaking the strings to int, due to problems with javascript " & '
	if(shop=="vote") {
		shop = 1;
	} 
	else if(shop="donate") {
		shop = 2;
	}
	$("#loading").html("Tem certeza de que deseja remover todos os itens da loja?<br/><input type='submit' value='Sim' onclick='clearShopNow(" + shop + ")'> <input type='submit' value='Não' onclick='hideLoader()'>");
}

function clearShopNow(shop) {
	$("#loading").html("Excluindo & Limpando...");
	$.post("../aasp_includes/scripts/shop.php", { action: "clear", shop: shop },
       function(data) {
			 $("#loading").html("A loja foi limpada!");
   });
	
}