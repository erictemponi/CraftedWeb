<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
if ($GLOBALS['enableSlideShow']==TRUE && !isset($_COOKIE['hideslider']) && $_GET['p']=='home') { ?>
<div class="main_view">
    <div class="window">
		<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
				<?php website::getSlideShowImages(); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
