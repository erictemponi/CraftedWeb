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
	 
<div class="box_right_title">Serviços do Personagem</div>
<table class="center">
<tr>
  <th>Serviço</th>
  <th>Preço</th>
  <th>Moeda</th>
  <th>Situação</th></tr>
<?php
$result = mysql_query("SELECT * FROM service_prices");
while($row = mysql_fetch_assoc($result)) { ?>
	<tr>
        <td><?php echo $row['service']; ?></td>
        <td><input type="text" value="<?php echo $row['price']; ?>" style="width: 50px;" id="<?php echo $row['service']; ?>_price" class="noremove"/></td>
        <td><select style="width: 200px;" id="<?php echo $row['service']; ?>_currency">
          <option value="vp">Pontos de Votação</option>
          <option value="dp">&lt;?php echo $GLOBALS['donation']['coins_name']; ?&gt;</option>
      </select></td>
        <td><select style="width: 150px;" id="<?php echo $row['service']; ?>_enabled">
          <option value="true">Habilitado</option>
          <option value="false">Desabilitado</option>
      </select></td>
        <td><input type="submit" value="Salvar" onclick="saveServicePrice('<?php echo $row['service']; ?>')"/>
  </tr>
<?php }
?>
</table>