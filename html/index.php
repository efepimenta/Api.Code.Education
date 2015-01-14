<?php
require_once __DIR__ . '/../src/bootstrap.php';

// pega a rota atual
$uri = $rotaService->currentUri();
try {
    // volta para o index se a rota nao existir no banco de dados
    if (! $rotaService->routeExists($em, $uri)) {
        header("Location:http://{$_SERVER['HTTP_HOST']}");
    }
} catch (Exception $e) {
	// gera uma exception se o banco de dados ou a tabela rotas nao existirem
    die('Banco de dados não foi encontrado');
    // mais pra frente eu crio uma forma de criar o banco e popular com os dados padroes
}

// se a rota nao for index, chama o arquivo correspondente
if ($uri != 'index') {
    $saida = '';
    foreach (explode('/', $uri) as $rt) {
        $saida = $saida . DIRECTORY_SEPARATOR . ucfirst($rt);
    }
    require_once __DIR__ . "/../src/Digital/Controller{$saida}.php";
    exit();
}
// se a rota for index, renderiza
echo $twig->render('index.twig', $dados);
