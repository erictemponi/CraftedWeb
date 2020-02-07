function calcConvert(divide) 
{
	var vp = document.getElementById("conv_vp").value;
	var dp = Math.floor(vp / divide);
	$("#conv_dp").val(dp);
}