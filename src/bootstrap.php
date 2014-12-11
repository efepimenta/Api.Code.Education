<?php

session_start();
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set("America/Sao_Paulo");

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application();
$app['debug'] = true;
$app['asset_path'] = 'http://' . $_SERVER['HTTP_HOST'].'/';
$app['asset_path2'] = 'http://' . $_SERVER['HTTP_HOST'];

$loader = new Twig_Loader_Filesystem(__DIR__ . '/Digital/View');
$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('path', function (){
	return 'http://' . $_SERVER['HTTP_HOST'].'/';
});
$twig->addFunction($function);