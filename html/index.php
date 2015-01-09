<?php

require_once __DIR__ . '/../src/bootstrap.php';
//pega a rota atual
$uri = $rotaService->currentUri();
// volta para o index se a rota nao existir no banco de dados
if (!$rotaService->routeExists($uri, $database)) {
    header("Location:http://{$_SERVER['HTTP_HOST']}");
}
//se a rota nao for index, chama o arquivo correspondente
if ($uri != 'index') {
    $saida = '';
    foreach (explode('/', $uri) as $rt) {
        $saida = $saida . DIRECTORY_SEPARATOR . ucfirst($rt);
    }
    require_once __DIR__ . "/../src/Digital/Controller{$saida}.php";
    exit();
}
//se a rota for index, renderiza
echo $twig->render('index.twig', $dados);
