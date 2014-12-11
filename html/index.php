<?php
use Digital\Entity\Produto;
use Digital\Database;
use Digital\Service\ProdutoService;

require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/settings.php';
include_once __DIR__ . '/../src/functions.php';

require_once __DIR__ . '/../src/bootstrap.php';

$database = new Database($driver);
$uri = currentUri();

if (!routeExists($uri, $database)){
  	header('Location:http://' . $_SERVER['HTTP_HOST']);
}

if ($uri != 'index') {
	require_once __DIR__ . "/../src/Digital/Controller/{$uri}.php";
// 	echo $twig->render("{$uri}.twig",['menu'=>montaMenu($database),'ano'=>date('Y')]);
	exit;
}

echo $twig->render('index.twig',['menu'=>montaMenu($database),'ano'=>date('Y')]);

$mapper = new ProdutoService($database);
$produto = new Produto();

$produto->setCategoria('2');
$produto->setNome('um nome');
$produto->setId('1');

if ($mapper->atualizar($produto)){
	echo $produto->getCategoria();
} else {
	echo 'nao atualizei nada<br>';
}

if ($mapper->deletar($produto->getId())){
	echo $produto->getCategoria();
	} else {
		echo 'nao apaguei nada<br>';
	}