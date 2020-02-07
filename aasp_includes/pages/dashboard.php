<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<div class="box_right_title">Visão Geral das Contas</div>
<table style="width: 605px;">
<tr>
<td><span class='blue_text'>Conexões Ativas</span></td><td><?php echo $server->getActiveConnections(); ?></td>
<td><span class='blue_text'>Contas ativas (Este mês)</span></td><td><?php echo $server->getActiveAccounts(); ?></td>
</tr>
<tr>
     <td><span class='blue_text'>Contas logadas hoje</span></td><td><?php echo $server->getAccountsLoggedToday(); ?></td> 
    <td><span class='blue_text'>Contas criadas hoje</span></td><td><?php echo $server->getAccountsCreatedToday(); ?></td>
</tr>
</table>
</div>

<?php
$server->checkForNotifications();
?>

<div class="box_right">
        <div class="box_right_title">Painel de registros do Administrador</div>
        <?php
                    $server->selectDB('webdb');
                    $result = mysql_query("SELECT * FROM admin_log ORDER BY id DESC LIMIT 10");
                    if(mysql_num_rows($result)==0) {
                        echo "Os registros do administrador estão vazios!";
                    } else { ?>
        <table class="center">
               <tr>
                 <th>Data</th>
                 <th>Usuário</th>
                 <th>Ação</th></tr>
                    <?php
                    while($row = mysql_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo date("Y-m-d H:i:s",$row['timestamp']); ?></td>
                            <td><?php echo $account->getAccName($row['account']); ?></td>
                            <td><?php echo $row['action']; ?></td>
                        </tr>
                    <?php }
               ?>
        </table><br/>
        <a href="?p=logs&s=admin" title="Get more logs">Registros mais antigos...</a>
        <?php } ?>
</div>