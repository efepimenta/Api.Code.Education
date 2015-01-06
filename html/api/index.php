<?php

use Symfony\Component\HttpFoundation\Response;

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

$app->mount('/produto/', include __DIR__ . '/../../src/Digital/Api/Controller/Produto.php');

$app->mount('/categoria/', include __DIR__ . '/../../src/Digital/Api/Controller/Categoria.php');

$app->run();