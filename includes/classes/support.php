<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
#################
# Unused class. #
#################
class support {
	
	public static function loadEmailForm() 
	{
		?><br/>
		<form action="?p=support&do=email" method="post">
        Questão: <bR/><select name="issue">
          <option>Problemas Técnicos</option>
          <option>Violação</option>
          <option>Outros...</option>
        </select><br/>
        Descreva o seu problema: <br/>
        <textarea name="description" cols="50" rows="7"></textarea>
        </form>
		<?php
	}
	
}

?>