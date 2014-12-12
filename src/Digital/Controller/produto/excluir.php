<?php
use Digital\Service\ProdutoService;
$service = new ProdutoService($database);

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'excluir')) {
	
	if ((empty($_POST['id']))) {
		echo $twig->render('produto/excluir.incompleto.twig', $dados);
		exit();
	}
	
	if ($service->deletar($_POST['id'])) {
		echo $twig->render("produto/excluir.ok.twig", $dados);
	}
	else {
		echo $twig->render("produto/excluir.erro.twig", $dados);
	}
}
else {
	$dados['produtos'] = $service->listar();
	echo $twig->render("produto/excluir.twig", $dados);
	unset($dados['produtos']);
}