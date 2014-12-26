<?php
/*
 * esse é o Controller Produto
 */
use Digital\Service\ProdutoService;
use Digital\Database;
use Digital\Paginator;

$service = new ProdutoService(new Database($driver)); /* classe database sera removida */

$paginator = new Paginator();

/*
 * tipos de entrada:
 * -> pelo link produtos
 * -> pelo botao buscar
 * -> pelo paginador
 */

if (isset($_GET['next'])) {
	$paginator->setAtivo(true);
	$paginator->setCampo($_GET['campo']);
	$paginator->setCriterio($_GET['criterio']);
	$paginator->setTermo($_GET['termo']);
	$paginator->setQuantidade($_GET['quantidade']);
	if ($_GET['next'] == ''){
		$paginator->setAtual(1);
		$paginator->setProximo(0);
	} else {
		$paginator->setAtual($_GET['next']);
		$paginator->setProximo($paginator->getQuantidade() * ($paginator->getAtual() -1));
	}
	
	$result = $service->buscaPersonalizada($em, $paginator);
	
	/* define a quantidade de botoes a serem usados no paginator */
	if ($paginator->getResultados() % $paginator->getQuantidade() != 0) {
		$botoes = intval($paginator->getResultados() / $paginator->getQuantidade()) + 1;
	}
	else {
		$botoes = intval($paginator->getResultados() / $paginator->getQuantidade());
	}
	if ($botoes == 0) {
		$botoes = 1;
	}
	$paginator->setBotoesTotais($botoes);
	if ($botoes > BOTOES) {
		$botoes = BOTOES;
	}
	$paginator->setBotoes($botoes);
}
else {
	$result = $service->findAll($em);
	$paginator->setAtivo(false);
	$paginator->setResultados($service->getRecordCount($em)[0][1]);
	$paginator->setAtual(1);
}

$dados['produtos'] = $result;
$dados['paginator'] = $paginator;

echo $twig->render("produto.twig", $dados);