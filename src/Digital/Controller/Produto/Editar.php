<?php

use Digital\Service\CategoriaService;
use Digital\Service\ProdutoService;
use Digital\Entity\Produto;
use Digital\Service\Validator\ProdutoValidator;
$cat = new CategoriaService($database);
$service = new ProdutoService($database);

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {

	$validator = new ProdutoValidator();
	if (! $validator->validar('atualizar', $_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['categoria'], $_POST['valor']) ){
		$dados['erros'] = $validator->mensagemDeErro();
		echo $twig->render('produto/editar.incompleto.twig', $dados);
		exit();
	}


	$produto = $validator->getProduto();

	$categoria = $cat->idPorDescricao($_POST['categoria'], true);
	$produto->setId($_POST['id']);
	$produto->setNome($_POST['nome']);
	$produto->setDescricao($_POST['descricao']);
	$produto->setId_categoria($categoria['id']);
	$produto->setValor($_POST['valor']);

	$result = $service->update($em, $produto);
	if ($result) {
		echo $twig->render("produto/editar.ok.twig", $dados);
	}
	else {
		$dados['erros'] = $result;
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