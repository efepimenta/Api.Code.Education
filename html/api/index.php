<?php

require_once __DIR__ . '/../../src/bootstrap.php';

$app->get('/', function (){
	return 'Welcome to the jungle';
});

$app->mount('/produto', include __DIR__ . '/../../src/Digital/Api/Controller/Produto.php');

$app->mount('/categoria', include __DIR__ . '/../../src/Digital/Api/Controller/Categoria.php');

$app->run();