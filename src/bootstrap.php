<?php

namespace Digital;

use Digital\Database;
use Digital\Service\CategoriaService;
use Digital\Service\LoginService;
use Digital\Service\MenuService;
use Digital\Service\ProdutoService;
use Digital\Service\RotaService;
use Digital\Service\Validator\CategoriaValidator;
use Digital\Service\Validator\ProdutoValidator;

if (empty ( session_id () )) {
	session_start ();
}

require_once __DIR__ . '/bootstrap-doctrine.php';
require_once __DIR__ . '/../src/settings.php';
require_once __DIR__ . '/../src/functions.php';

/* ----------------------------------------------------------------------- */
/*
 * confituracao do twig
 */
$loader = new \Twig_Loader_Filesystem ( __DIR__ . '/Digital/View' );
$twig = new \Twig_Environment ( $loader, array (
		'debug' => true 
) );
$function = new \Twig_SimpleFunction ( 'path', function () {
	return "http://{$_SERVER['HTTP_HOST']}/";
} );
$twig->addFunction ( $function );
/* ----------------------------------------------------------------------- */
/*
 * configurações gerais
 */
$loginService = new LoginService ();
$database = new Database ( $driver );
$rotaService = new RotaService ();
$menuService = new MenuService ( $database );
$dados = [ 
		'title' => 'Doctrine Rules',
		'menu' => $menuService->montaMenu ( $database ),
		'ano' => date ( 'Y' ),
		'logado' => $loginService->logado (),
		'uri' => $rotaService->currentUri () 
];
/* ----------------------------------------------------------------------- */
/*
 * configuracao do Silex
 */
$app = new \Silex\Application ();
$app ['debug'] = true;
$app ['em'] = $em;

$app ['produtoservice'] = function () use($app) {
	return new ProdutoService ();
};
$app ['produtovalidator'] = function () {
	return new ProdutoValidator ();
};
$app ['categoriaservice'] = function () use($app) {
	return new CategoriaService ();
};
$app ['categoriavalidator'] = function () {
	return new CategoriaValidator ();
};
