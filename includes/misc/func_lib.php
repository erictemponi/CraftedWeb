<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
function exit_page() 
{
	die("<h1>Erro do Site</h1>
		Algo deu errado no script do site. Entre em contato com o webmaster caso o problema continue. 
		<br/>
		<br/>
		<br/>
		<i>CraftedWeb</i>");
}

function RandomString() 
{
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    
    for ($p = 0; $p < $length; $p++) 
	{
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

function convTime($time)
{
	if($time<60) 
	{
		if ($time == 1)
			$string = 'Segundo';
		else
			$string = 'Segundos';
	}
		elseif ($time > 60) 
		{
		    $time = $time / 60;
			if ($time == 1)
				$string = 'Minuto';
			else
				$string = 'Minutos'; 
		if ($time > 60) 
		{									 
			$time = $time / 60;
			if ($time == 1)
				$string = 'Hora';
			else
				$string = 'Horas';
	    if ($time > 24) 
		{
			$time = $time / 24;
			if ($time == 1)
				$string = 'Dia';
			else
				$string = 'Dias';
		}
		}
			$time = ceil($time);
		}
		return $time." ".$string;
}
?>