<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

account::isNotLoggedIn(); ?>

<div class='box_two_title'>Votar</div>

<h4 class="yellow_text">Pontos de Votação: <?php echo account::loadVP($_SESSION['cw_user']); ?></h4>

<?php website::loadVotingLinks(); ?>