var loadedPayments = 0;
var loadedDshop = 0;
var loadedVshop = 0;

function loadPaymentsLog(id) {
	if(loadedPayments==0) {
	loader("#payments");
	$.post("../aasp_includes/scripts/logs.php", { action: 'payments',id: id },
       function(data) {
          $("#payments").html(data);
		  loadedPayments = 1;
   });
  }
}

function loadDshopLog(id) {
	if(loadedDshop==0) {
	loader("#dshop");
	$.post("../aasp_includes/scripts/logs.php", { action: 'dshop', id: id },
       function(data) {
          $("#dshop").html(data);
		  loadedDshop = 1;
   });
  }
}

function loadVshopLog(id) {
	if(loadedVshop==0) {
	loader("#vshop");
	$.post("../aasp_includes/scripts/logs.php", { action: 'vshop', id: id },
       function(data) {
          $("#vshop").html(data);
		  loadedVshop = 1;
   });
  }
}

$(".payments").click(function() {
	if($(this).next().is(":hidden")) {
			 $(this).next().fadeIn("fast");
		} else {
          $(this).next().fadeOut("fast");
		}
});

function searchLog(shop) {
	var input = document.getElementById("logs_search").value;
	if(input=="") {
		$("#logs_search").val("Procurando...");
	}
	$.post("../aasp_includes/scripts/logs.php", { action: 'search', shop: shop, input: input },
       function(data) {
          $("#logs_content").html(data);
   });
}