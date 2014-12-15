<?php

ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set("America/Sao_Paulo");

$db_settings = ["protocol" => "mysql","host" => "localhost","dbname" => "site","user" => "root","pass" => "root"];

$driver = new \PDO("{$db_settings['protocol']}:host={$db_settings['host']};dbname={$db_settings['dbname']}", 
	$db_settings['user'], $db_settings['pass']);
