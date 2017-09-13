<?php

class Helper
{
	/**
	* Método para criar um active na url atual
	*
	* @method active()
	* @return void 
	*/
	public static function active($link)
	{
		$url = explode('.', $_SERVER['PHP_SELF']);
		if($link==ltrim($url[0],'/'))
			echo 'class="active"';
	}
}