<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<script type="text/javascript" src="../aasp_includes/js/interface.js"></script>
<script type="text/javascript" src="../aasp_includes/js/account.js"></script>
<script type="text/javascript" src="../aasp_includes/js/server.js"></script>
<script type="text/javascript" src="../aasp_includes/js/news.js"></script>
<script type="text/javascript" src="../aasp_includes/js/logs.js"></script>
<script type="text/javascript" src="../aasp_includes/js/shop.js"></script>
<?php if($GLOBALS['core_expansion']>2) 
{
	//Core is over WOTLK. Use WoWHead.
	echo '<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>';
}
else
{
	echo '<script type="text/javascript" src="http://cdn.openwow.com/api/tooltip.js"></script>';
}
?>
<script type="text/javascript" src="../aasp_includes/js/wysiwyg.js"></script>
<script type="text/javascript" src="../aasp_includes/js/wysiwyg/wysiwyg.image.js"></script>
<script type="text/javascript" src="../aasp_includes/js/wysiwyg/wysiwyg.link.js"></script>
<script type="text/javascript" src="../aasp_includes/js/wysiwyg/wysiwyg.table.js"></script>

<script type="text/javascript">
$(function() {
        $('#wysiwyg').wysiwyg();
    });
</script>