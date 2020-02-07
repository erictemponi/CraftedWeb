<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Menu</div>
<table class="center">
        <tr>
          <th>Posição</th>
          <th>Título</th>
          <th>URL</th>
          <th>Exibido quando</th>
          <th>Ações</th></tr>
        <?php 
        $x = 1;
            $result = mysql_query("SELECT * FROM site_links ORDER BY position ASC");
            while($row = mysql_fetch_assoc($result)) { ?>
                <tr><td><?php echo $x; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['url']; ?></td>
                <td><?php 
						if($row['shownWhen']=='logged') {
							echo "Logado";
						} elseif($row['shownWhen']=='notlogged') {
							echo "Não logado";
						}  else {
							echo ucfirst($row['shownWhen']);
						}
                   ?>
                </td>
                <td>
                    <a href="#" onclick="editMenu(<?php echo $row['position']; ?>)"
                    >Editar</a> &nbsp; <a href="#" onclick="deleteLink(<?php echo $row['position']; ?>)">Deletar</a>
                </td>
                </tr>
            <?php $x++; }
        ?>
 </table>
 <br/>
 <a href="#" onclick="addLink()" class="content_hider">Add um novo link</a>