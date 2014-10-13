<?php

class Flash{
	public static function load($app,$string)
	{
		$app->config('flash.message', $string);
		return $app;
	}
	
	public static function unload($app)
	{
		$app->config('flash.message', null);
		return $app;
	}
	
	public static function get($app)
	{
		$string = $app->config('flash.message');
		$app->config('flash.message', null);
		return $string;
	}
	

}

?>
