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
$server = new server;
$account = new account;
?>
	 
<div class="box_right_title">Registros da Loja de Votação</div>
<?php 

$per_page = 40;
								   
$pages_query = mysql_query("SELECT COUNT(*) FROM shoplog WHERE shop='vote'");
$pages = ceil(mysql_result($pages_query,0) / $per_page );

$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

$result = mysql_query("SELECT * FROM shoplog WHERE shop='vote' ORDER BY id DESC LIMIT ".$start.",".$per_page); 
if(mysql_num_rows($result)==0) {
	echo "Parece que os registros da Loja de Votação estão vazios!";
} else {
?>
 <input type='text' value='Procurar...' id="logs_search" onkeyup="searchLog('vote')">
 <?php echo "<br/><b>Mostrando ".$start."-".($start + $per_page)."</b>"; ?>
 <hr/>
<div id="logs_content">
<table width="100%">
        <tr>
          <th>Usuário</th>
          <th>Personagem</th>
          <th>Reino</th><th>Item</th>
          <th>Data</th></tr>
        <?php while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
        </tr>	
		<?php } ?>
</table>
<hr/>

<?php
if($pages>=1 && $page <= $pages) 
{
	if($page>1)
	{
	   $prev = $page-1;
	   echo '<a href="?p=logs&s=voteshop&page='.$prev.'" title="Previous">Anterior</a> &nbsp;';
	}
	for($x=1; $x<=$pages; $x++)
	{
		if($page == $x) 
		   echo '<a href="?p=logs&s=voteshop&page='.$x.'" title="Page '.$x.'"><b>'.$x.'</b></a> ';
		else   
		   echo '<a href="?p=logs&s=voteshop&page='.$x.'" title="Page '.$x.'">'.$x.'</a> ';
	}
	
	if($page<$x - 1)
	{
	   $next = $page+1;
	   echo '&nbsp; <a href="?p=logs&s=voteshop&page='.$next.'" title="Next">Próximo</a> &nbsp; &nbsp;';
	}
}
?>
</div>
<?php } ?>