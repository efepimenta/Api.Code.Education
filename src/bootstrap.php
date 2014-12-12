<?php
use Digital\Service\LoginService;
use Digital\Database;
use Digital\Service\RotaService;
use Digital\Service\MenuService;
if (empty(session_id())) {
	session_start();
}
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set("America/Sao_Paulo");

require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/settings.php';

$loader = new Twig_Loader_Filesystem(__DIR__ . '/Digital/View');
$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('path', function () {
	return "http://{$_SERVER['HTTP_HOST']}/";
});
$twig->addFunction($function);

$loginService = new LoginService();
$database = new Database($driver);
$rotaService = new RotaService();
$menuService = new MenuService($database);

$dados = ['menu' => $menuService->montaMenu($database),'ano' => date('Y'),'logado' => $loginService->logado(),'uri' => $rotaService->currentUri()];

