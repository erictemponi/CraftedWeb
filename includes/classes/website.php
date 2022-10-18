<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

########################
## Scripts containing website functions will be added here. News for example.
#######################

class website {

	public static function getNews()
	{
		if ($GLOBALS['news']['enable']==true) {
			echo '<div class="box_two_title">Últimas Notícias</div>';

		if (cache::exists('news')==TRUE)
				cache::loadCache('news');
		else
		{
	        connect::selectDB('webdb');

		    $result = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT ".$GLOBALS['news']['maxShown']);
			if (mysql_num_rows($result)==0)
				echo 'Nenhuma notícia foi encontrada';
			else
			{
				$output = NULL;
				while($row = mysql_fetch_assoc($result))
				{
					if(file_exists($row['image']))
					{
					echo $newsPT1 =  '
					       <table class="news" width="100%">
						        <tr>
								    <td><h3 class="yellow_text">'.$row['title'].'</h3></td>
							    </tr>
						   </table>
                           <table class="news_content" cellpadding="4">
						       <tr>
						          <td><img src="'.$row['image'].'" alt=""/></td>
						          <td>';
					}
					else
					{
						echo $newsPT1 =  '
					       <table class="news" width="100%">
						        <tr>
								    <td><h3 class="yellow_text">'.$row['title'].'</h3></td>
							    </tr>
						   </table>
                           <table class="news_content" cellpadding="4">
						       <tr>
						           <td>';
					}
					   $output .= $newsPT1;
					   unset($newsPT1);

						$text = html_entity_decode(preg_replace("
						  #((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie",
						 "'<a href=\"$1\" target=\"_blank\">http://$3</a>$4'",
						 $row['body']
						));

						if ($GLOBALS['news']['limitHomeCharacters']==true)
						{
							echo website::limit_characters($text,200);
							$output.= website::limit_characters($row['body'],200);
						}
						else
						{
							 echo nl2br($text);
							 $output .= nl2br($row['body']);
						}
						$commentsNum = mysql_query("SELECT COUNT(id) FROM news_comments WHERE newsid='".$row['id']."'");

						if($GLOBALS['news']['enableComments']==TRUE)
							 $comments = '| <a href="?p=news&amp;newsid='.$row['id'].'">Comentários ('.mysql_result($commentsNum,0).')</a>';
						  else
							 $comments = '';
						 
						$date = date_create($row['date']);
						echo $newsPT2 = '
						<br/><br/><br/>
						<i class="gray_text"> Produzido por '.$row['author'].' no dia '.date_format($date, "d/m/Y à\s H:i:s").' '.$comments.'</i>
						</td>
						</tr>
					    </table>';
						$output .= $newsPT2;
						unset($newsPT2);
				}
					echo '<hr/>
						  <a href="?p=news">Ver todas as notícias...</a>';
					cache::buildCache('news',$output);
			}
		}
	}
}


	public static function getSlideShowImages()
	{
		if (cache::exists('slideshow')==TRUE)
			cache::loadCache('slideshow');
	    else
	    {
			connect::selectDB('webdb');
			$result = mysql_query("SELECT path,link FROM slider_images ORDER BY position ASC");
			while($row = mysql_fetch_assoc($result))
			{
				echo $outPutPT = '<a href="'.$row['link'].'">
								  <img border="none" src="'.$row['path'].'" alt="" />
								  </a>';
				$output .= $outPutPT;
			}
			cache::buildCache('slideshow',$output);
	  }
	}

	public static function limit_characters($str,$n)
	{
		$str = preg_replace("/<img[^>]+\>/i", "(image)", $str);

		if (strlen($str) <= $n)
			return $str;
		else
			return substr ($str, 0, $n).'...';
    }


	public static function loadVotingLinks()
	{
		connect::selectDB('webdb');
		$result = mysql_query("SELECT * FROM votingsites ORDER BY id DESC");
		if (mysql_num_rows($result)==0)
			buildError("Não foi possível obter todos os Links de Votação a partir do Banco de Dados. ".mysql_error());
		else
		{
			while($row = mysql_fetch_assoc($result)) {
			?>
            <div class='votelink'>
            <table width="100%">
                <tr>
                    <td width="20%"><img src="<?php echo $row['image']; ?>" /></td>
                    <td width="50%"><strong><?php echo $row['title']; ?></strong> (<?php echo $row['points']; ?> Pontos de Votação)<td>
                    <td width="40%">
					<?php if(website::checkIfVoted($row['id'])==FALSE) {?>
                    		<input type='submit' value='Votar'  onclick="vote('<?php echo $row['id']; ?>',this)">
					<?php
						 }
						 else
						 {
							 $getNext = mysql_query("SELECT next_vote FROM ".$GLOBALS['connection']['webdb'].".votelog
													 WHERE userid='".account::getAccountID($_SESSION['cw_user'])."'
													 AND siteid='".$row['id']."' ORDER BY id DESC LIMIT 1");

							 $row = mysql_fetch_assoc($getNext);
							 $time = $row['next_vote'] - time();

							 echo 'Tempo até o reset: '.convTime($time);
						 }
						 ?>
                         </td>
                     </tr>
              </table>
              </div>
			  <?php
		  }
	   }
	}

	public static function checkIfVoted($siteid)
	{
		$siteid = (int)$siteid;
		$acct_id = account::getAccountID($_SESSION['cw_user']);

		connect::selectDB('webdb');

		$result = mysql_query("SELECT COUNT(id) FROM votelog
		WHERE userid='".$acct_id."' AND siteid='".$siteid."' AND next_vote > ".time());

		if (mysql_result($result,0)==0)
			return FALSE;
		 else
			return TRUE;
	}

	public static function sendEmail($to,$from,$subject,$body)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from . "\r\n";
		
		if (mail($to,$subject,$body,$headers)) {
			return true;
		}
		return false;
	}

	public static function convertCurrency($currency)
	{
		if($currency=='dp')
			return $GLOBALS['donation']['coins_name'];
		elseif($currency=='vp')
			return "Pontos de Votação";
	}
}

?>

