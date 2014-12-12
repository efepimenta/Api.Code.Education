<?php

require_once __DIR__ . '/../src/bootstrap.php';

$uri = $rotaService->currentUri();

if (! $rotaService->routeExists($uri, $database)) {
	header("Location:http://{$_SERVER['HTTP_HOST']}");
}

if ($uri != 'index') {
	require_once __DIR__ . "/../src/Digital/Controller/{$uri}.php";
	exit();
}

echo $twig->render('index.twig', $dados);

