<?php

require_once __DIR__ . '/vendor/autoload.php';

$exec = function ($sql)
{
    $db_settings = ["protocol" => "mysql", "host" => "localhost", "dbname" => "site", "user" => "root", "pass" => "root"];
    $driver = new \PDO("{$db_settings['protocol']}:host={$db_settings['host']}", $db_settings['user'], $db_settings['pass']);
    $driver->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $st = $driver->exec($sql);
    return $st > 0;
};


$sql = file_get_contents('site.sql');
$exec($sql);