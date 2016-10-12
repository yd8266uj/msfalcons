<?php

spl_autoload_register(function ($name) {
	$class_name = strtolower($name);
  if( preg_match('/^i_*/',$name)) include "../interfaces/$name.php";
  elseif( preg_match('/^t_*/',$name)) include "../tests/$name.php";
	else include "../classes/$name.php";
});

?>