<?php

class TemplatyThemeOptionsDefaults
{
	private static $_DEFAULTS = array();
	
	public static function Set($key, $value)
	{
		self::$_DEFAULTS[$key] = $value;
	}
	
	public static function Get($key)
	{
		return isset(self::$_DEFAULTS[$key]) ? self::$_DEFAULTS[$key] : ""; 
	}
}
