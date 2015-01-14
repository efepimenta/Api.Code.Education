<?php

// use Symfony\Component\HttpFoundation\Response;
use Digital\Api\Controller\ProdutoApiController;
use Digital\Api\Controller\CategoriaApiController;
use Digital\Api\Controller\TagApiController;

require_once __DIR__ . '/../../src/bootstrap.php';

/* error aqui */
// $app->error(function (\Exception $e, $code) {
//    var_dump($code);exit;
//     switch ($e->getStatusCode()) {
//         case 404:
//             $message = 'The requested page could not be found.';
//             break;
//         default:
//             $message = 'We are sorry, but something went terribly wrong.';
//     }

//     return new Response($message);
// });

$app->get('/', function () {
    return 'Welcome to the jungle';
});

$produto = new ProdutoApiController();
$app->mount('/produto/', $produto->getController($app));

$categoria = new CategoriaApiController();
$app->mount('/categoria/', $categoria->getController($app));

$tag = new TagApiController();
$app->mount('/tag/', $tag->getController($app));

$app->run();