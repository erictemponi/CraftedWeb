<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<?php
if($GLOBALS['social']['enableFacebookModule']==TRUE) { 
?>
	<div class="box_one">
	<div class="box_one_title">Encontre-nos no Facebook</div>
    <div id="fb-root"></div>
		<script>
		(function(d, s, id) 
		{
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
    
    <div class="fb-like-box" data-href="<?php echo $GLOBALS['social']['facebookGroupURL']; ?>" id="fb" data-colorscheme="dark" data-show-faces="false" 			data-border-color="#333" data-stream="true" data-header="false"></div>
    </div>
<?php } ?>