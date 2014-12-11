<?php
$db_settings = ["protocol" => "mysql","host" => "localhost","dbname" => "site","user" => "root","pass" => "root"];

$driver = new \PDO("{$db_settings['protocol']}:host={$db_settings['host']};dbname={$db_settings['dbname']}", 
	$db_settings['user'], $db_settings['pass']);