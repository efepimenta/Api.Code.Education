<?php

require_once __DIR__ . '/vendor/autoload.php';

$db_settings = ["protocol" => "mysql", "host" => "localhost", "dbname" => "site", "user" => "root", "pass" => "root"];
$driver = new \PDO("{$db_settings['protocol']}:host={$db_settings['host']}", $db_settings['user'], $db_settings['pass']);
$db = new \Digital\Database($driver);

$sql = file_get_contents('site.sql');
$db->exec($sql);