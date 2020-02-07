<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
##############
# Start session
############## 
if(!isset($_SESSION)) 
      session_start();

############
# Start ob
############
ob_start();

############
# Enable all errors. None will be shown due to our custom errors.
############
ini_set('display_errors',1);
error_reporting(E_ALL);

//Start microtime.
$start = microtime(true);
?>