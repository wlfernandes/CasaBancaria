<?php

function __autoload($class)
{
	$class = "classes/{$class}.php";

	if(file_exists($class))
		require $class;
	else
		echo "Classe {$class} não encontrada !<br>";
}