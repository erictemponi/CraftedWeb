<?php
/*
              _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
#############################
## STAFF PANEL LOADER FILE ##
## ------------------------##
#############################

require('../includes/misc/headers.php'); //Load headers

define('INIT_SITE', TRUE);
include('../includes/configuration.php');

if($GLOBALS['adminPanel_enable']==FALSE)
	exit();

require('../includes/misc/compress.php'); //Load compression file
include('../aasp_includes/functions.php');

$server = new server;
$account = new account;
$page = new page;

$server->connect();

if(isset($_SESSION['cw_staff']) && !isset($_SESSION['cw_staff_id']) && $_GET['p']!='notice')
{
    header("Location: ?p=notice&e=Parece que não foi iniciada uma sessão. Você foi desconectado para evitar qualquer ameaça ao site");
    exit;
}