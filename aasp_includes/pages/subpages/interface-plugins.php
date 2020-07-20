<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page;
	  $server = new server; ?>
<div class="box_right_title">Plugins</div>
<table>
	<tr>
    	<th>Nome</th>
        <th>Descrição</th>
        <th>Autor</th>
        <th>Criado</th>
        <th>Situação</th>
    </tr>
<?php
	$bad = array('.','..','index.html');
	
	$folder = scandir('../plugins/');
	foreach($folder as $folderName)
	{
		if(!in_array($folderName,$bad))
		{
			if(file_exists('../plugins/'.$folderName.'/info.php'))
			{
				include('../plugins/'.$folderName.'/info.php');
				?> <tr class="center" onclick="window.location='?p=interface&s=viewplugin&plugin=<?php echo $folderName; ?>'"> <?php
					echo '<td><a href="?p=interface&s=viewplugin&plugin='.$folderName.'">'.$title.'</a></td>';
					echo '<td>'.substr($desc,0,42).'...</td>';
					echo '<td>'.$author.'</td>';
					echo '<td>'.$created.'</td>';
					$server->selectDB('webdb');
					$chk = mysql_query("SELECT COUNT(*) FROM disabled_plugins WHERE foldername='".mysql_real_escape_string($folderName)."'");
					if(mysql_result($chk,0)>0)
						echo '<td>Desabilitado</td>';
					else
						echo '<td>Habilitado</td>';
				echo '</tr>';
			}
		}
	}
	
	if($count==0)
	{
		$_SESSION['loaded_plugins'] = NULL;
	}
	else
	{
		$_SESSION['loaded_plugins'] = $loaded_plugins;
	}
?>
</table>