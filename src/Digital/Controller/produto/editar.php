<?php

use Digital\Service\CategoriaService;
use Digital\Service\ProdutoService;
use Digital\Entity\Produto;
$cat = new CategoriaService($database);
$service = new ProdutoService($database);

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {

	if ((empty($_POST['id'])) || (empty($_POST['nome'])) || (empty($_POST['descricao'])) || (empty($_POST['valor'])) || (empty($_POST['categoria']))) {
		echo $twig->render('produto/editar.incompleto.twig', $dados);
		exit();
	}

	$produto = new Produto();

	$categoria = $cat->idPorDescricao($_POST['categoria'], true);
	$produto->setId($_POST['id']);
	$produto->setNome($_POST['nome']);
	$produto->setDescricao($_POST['descricao']);
	$produto->setCategoria($categoria['id']);
	$produto->setValor($_POST['valor']);

	if ($service->atualizar($produto)) {
		echo $twig->render("produto/editar.ok.twig", $dados);
	}
	else {
		echo $twig->render("produto/editar.erro.twig", $dados);
	}
}
else {
	$dados['categorias'] = $cat->listar();
	$dados['produtos'] = $service->listar();
	echo $twig->render("produto/editar.twig", $dados);
	unset($dados['categorias']);
	unset($dados['produtos']);
}