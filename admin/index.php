<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php require('includes/loader.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $GLOBALS['website_title']; ?> Painel do Administrador</title>
<link rel="stylesheet" href="../aasp_includes/styles/default/style.css" />
<link rel="stylesheet" href="../aasp_includes/styles/wysiwyg.css" />
<script type="text/javascript" src="../javascript/jquery.js"></script>
</head>

<body>
<div id="overlay"></div>
<div id="loading"><img src="../aasp_includes/styles/default/images/ajax-loader.gif" /></div>
<div id="leftcontent">
        <div id="menu_left">
                          <ul>
                              <li id="menu_head">Menu</li>
                              <li>Painel de Controle</li>
                                   <ul class="hidden" <?php activeMenu('dashboard'); ?>>
                                       <a href="?p=dashboard">Painel de Controle</a>
                                       <!--<a href="?p=updates">Atualizações</a>-->
                                   </ul>
                              <li>Páginas</li>
                                   <ul class="hidden" <?php activeMenu('pages'); ?>>
                                       <a href="?p=pages">Todas as Páginas</a>
                                       <a href="?p=pages&s=new">Add Nova</a>
                                   </ul>
                              <li>Notícias</li>
                                   <ul class="hidden" <?php activeMenu('news'); ?>>
                                       <a href="?p=news">Postar notícia</a>
                                       <a href="?p=news&s=manage">Gerenciar notícias</a>
                                   </ul>     
                              <li>Loja</li>
                                    <ul class="hidden" <?php activeMenu('shop'); ?>>
                                       <a href="?p=shop">Visão Geral</a>
                                       <a href="?p=shop&s=add">Add itens</a>
                                       <a href="?p=shop&s=manage">Gerenciar itens</a>
                                       <a href="?p=shop&s=tools">Ferramentas</a>
                                   </ul> 
                              <li>Doações</li>
                                   <ul class="hidden" <?php activeMenu('donations'); ?>>
                                       <a href="?p=donations">Visão Geral</a>
                                       <a href="?p=donations&s=browse">Procurar</a>
                                   </ul> 
                              <li>Registros</li>
                                    <ul class="hidden" <?php activeMenu('logs'); ?>>
                                       <a href="?p=logs&s=voteshop">Loja de Votação</a>
                                       <a href="?p=logs&s=donateshop">Loja de Doação</a>
                                       <a href="?p=logs&s=admin">Painel do Administrador</a>
                                   </ul> 
                              <li>Interface</li>
                                    <ul class="hidden" <?php activeMenu('interface'); ?>>
                                       <a href="?p=interface">Modelo</a>
                                       <a href="?p=interface&s=menu">Menu</a>
                                       <a href="?p=interface&s=slideshow">Slideshow</a>
                                       <a href="?p=interface&s=plugins">Plugins</a>
                                   </ul> 
                              <li>Usuários</li>
                                    <ul class="hidden" <?php activeMenu('users'); ?>>
                                       <a href="?p=users">Visão Geral</a>
                                       <a href="?p=users&s=manage">Gerenciar Usuários</a>
                                   </ul> 
                              <li>Reinos</li>
                                    <ul class="hidden" <?php activeMenu('realms'); ?>>
                                       <a href="?p=realms">Novo reino</a>
                                       <a href="?p=realms&s=manage">Gerenciar reino(s)</a>
                                   </ul> 
                              <li>Serviços</li>
                                    <ul class="hidden" <?php activeMenu('services'); ?>>
                                       <a href="?p=services&s=voting">Links de Votação</a>
                                       <a href="?p=services&s=charservice">Serviços de Personagem</a>
                                   </ul> 
                              <li>Ferramentas</li>
                                    <ul class="hidden" <?php activeMenu('tools'); ?>>
                                       <a href="?p=tools&s=tickets">Tickets</a>
                                       <a href="?p=tools&s=accountaccess">Acesso à Conta</a>
                                   </ul>    
							  <li onclick="window.location='?p=credits'">Créditos</li>   
                          </ul>
         </div>
</div>

<div id="header">
<div id="header_text">
  <?php if(isset($_SESSION['cw_admin'])) { ?> Bem-vindo(a)  
     <b><?php echo $_SESSION['cw_admin']; ?> </b> 
     <a href="?p=logout"><i>(Sair)</i></a> &nbsp; | &nbsp;
     <a href="<?php echo $GLOBALS['website_domain']; ?>" title="Visualizar seu Site">Visualizar seu Site</a>
     <?php } else {
         echo "Por favor, faça login.";
     }?>
 </div>
</div>
      
      
<div id="wrapper">
<div id="middlecontent">
<?php if(!isset($_SESSION['cw_admin'])) { ?>  
<br/>
<center>
<h2>Por favor, faça login</h2>
  <input type="text" placeholder="Nome de Usuário" id="login_username" style="border: 1px solid #ccc;"/><br/> 
  <input type="password" placeholder="Senha" id="login_password" style="border: 1px solid #ccc;"/><br/>
  <input type="submit" value="Entrar" onclick="login('admin')"/> <br/>
  <div id="login_status"></div>
</center>
 <?php 
 } 
 else 
 { 
 ?>
    <div class="box_right">
    <?php
		if(!isset($_GET['p']))
                 $page = "dashboard";
		 else 
		 { 
			 $page = $_GET['p']; }		   
			 $pages = scandir('../aasp_includes/pages');
			 unset($pages[0],$pages[1]);
			 
			 if (!file_exists('../aasp_includes/pages/'.$page.'.php'))
				 include('../aasp_includes/pages/404.php');
			 elseif(in_array($page.'.php',$pages))
				 include('../aasp_includes/pages/'.$page.'.php');
			 else
				 include('../aasp_includes/pages/404.php');              
		  }
    ?>
    <?php if($GLOBALS['forum']['type']=='phpbb' && $GLOBALS['forum']['autoAccountCreate']==TRUE && $page=='dashboard') { ?>
         <div class="box_right">
         <div class="box_right_title">Atividade Recente do forum</div>
            <table width="100%">
                <tr>
                    <th>Conta</th>
                    <th>Tópico</th>
                    <th>Mensagem</th>
                    <th>Tópico</th>
                </tr>
			<?php
            $server->selectDB($GLOBALS['forum']['forum_db']);
            $result = mysql_query("SELECT poster_id,post_text,post_time,topic_id FROM phpbb_posts ORDER BY post_id DESC LIMIT 10");
            while($row = mysql_fetch_assoc($result)) 
			{
                $string = $row['post_text']; 
                //Lets get the username			
                $getUser = mysql_query("SELECT username FROM phpbb_users WHERE user_id='".$row['poster_id']."'"); 
				$user = mysql_fetch_assoc($getUser);
                //Get topic
                $getTopic = mysql_query("SELECT topic_title FROM phpbb_topics WHERE topic_id='".$row['topic_id']."'"); 
				$topic = mysql_fetch_assoc($getTopic);
            ?>
                <tr class="center">
                    <td>
                    <a href="<?php echo $GLOBALS['website_domain'].
					substr($GLOBALS['forum']['forum_path'],1) ?>memberlist.php?mode=viewprofile&u=<?php echo $row['poster_id']; ?>" 
                    title="Visualizar perfil" target="_blank"><?php echo $user['username']; ?></a>
                    </td>
                    <td><?php echo $topic['topic_title']; ?></td>
                    <td><?php echo limit_characters(strip_tags($string),75);?>...</td>
                    <td><a href="<?php echo $GLOBALS['website_domain'].substr($GLOBALS['forum']['forum_path'],1); ?>viewtopic.php?t=<?php echo $row['topic_id']?>" 
                    title="Visualizar este tópico" target="_blank">
                    	Visualizar tópico</a></td>
                </tr>
            <?php } ?>
        </table>
         </div> 
             <?php } ?>
     </div>
     
</div>
    <?php if(isset($_SESSION['cw_admin']))  { ?>
    <div id="rightcontent">
     <div class="box_right">
            <div class="box_right_title">Situação do Servidor</div>
            <?php $server->serverStatus(); ?>
     </div>    
                         
    <div class="box_right">
    <div class="box_right_title">Configurações do Site</div>
    <table>
           <tr valign="top">
               <td>
                Host da MySQL: <br/>
                Usuário da MySQL: <br/>
                Senha da MySQL: <br/>
               </td>
               <td>
               <b>
               <?php echo $GLOBALS['connection']['host'];?><br/>
               <?php echo $GLOBALS['connection']['user']; ?><br/>
               <?php echo substr($GLOBALS['connection']['password'],0,4); ?>****<br/>
               </b>
               </td>
               <td>
               Banco de Dados de Logon: <br/>
               Banco de Dados do Site: <br />
               Banco de Dados do Mundo: <br/>
               Revisão do Banco de Dados: 
               </td>
               <td>
               <b>
               <?php echo $GLOBALS['connection']['logondb']; ?><br/>
               <?php echo $GLOBALS['connection']['webdb']; ?><br/>
               <?php echo $GLOBALS['connection']['worlddb']; ?><br/>
               <?php 
                     $server->selectDB('webdb');
                     $get = mysql_query("SELECT version FROM db_version");
                     $row = mysql_fetch_assoc($get);
                     echo $row['version']; ?>
               </b>
               </td>
           </tr>
    </table>
</div>          
</div>         
  <?php } ?>
</div>               
</div> 
	<?php include("../aasp_includes/javascript_loader.php"); 
	if(!isset($_SESSION['cw_admin']))
	{
	?>
    <script type="text/javascript">
 	document.onkeydown = function(event) 
	{
		var key_press = String.fromCharCode(event.keyCode);
		var key_code = event.keyCode;
		if(key_code == 13)
			{
				login('admin')
			}
	}
 </script>
 <?php } ?>
</body>
</html>