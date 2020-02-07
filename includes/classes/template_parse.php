<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
class Page
{
  var $page;
  var $values = array();

  function Page($template) 
  {
    if (file_exists($template))
      $this->page = join("", file($template));
  }

  function parse($file) 
  {
		ob_start();
		include($file);
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
  }

  function replace_tags($tags = array()) 
  {
      if (sizeof($tags) > 0)
      foreach ($tags as $tag => $data) 
	  {
			$data = (file_exists($data)) ? $this->parse($data) : $data;
			$this->page = preg_replace("({" . $tag . "})", $data,
						  $this->page);
	  }
  }
  
  function setVar($key,$array) 
  {
	  $this->values[$key] = $array;
  }

  function output() 
  {
        echo $this->page;
  }
  
  function loadCustoms() 
  { 
    if($GLOBALS['enablePlugins']==true)
	{
		if(isset($_SESSION['loaded_plugins_modules']))
		{
			foreach($_SESSION['loaded_plugins_modules'] as $filename)
			{
				$name = basename(substr($filename,0,-4));
				
				$this->replace_tags(array($name => $filename));
			}
		}
	}
 }
}
?>