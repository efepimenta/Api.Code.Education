<?php
use Digital\Service\ProdutoService;
use Digital\Database;
use Digital\Entity\Produto;
use Digital\Service\CategoriaService;

$cat = new CategoriaService($database);

if ((isset($_POST['acao'])) and ($_POST['acao'] === 'salvar')) {
	
	if ((empty($_POST['nome'])) || (empty($_POST['descricao'])) || (empty($_POST['valor'])) || (empty($_POST['categoria']))) {
		echo $twig->render('produto/novo.incompleto.twig', $dados);
		exit();
	}
	
	$service = new ProdutoService($database);
	$produto = new Produto();
	
	$categoria = $cat->idPorDescricao($_POST['categoria'], true);
	$produto->setNome($_POST['nome']);
	$produto->setDescricao($_POST['descricao']);
	$produto->setCategoria($categoria['id']);
	$produto->setValor($_POST['valor']);
	
	if ($service->inserir($produto)) {
		echo $twig->render("produto/novo.ok.twig", $dados);
	}
	else {
		echo $twig->render("produto/novo.erro.twig", $dados);
	}
}
else {
	$dados['categorias'] = $cat->listar();
	echo $twig->render("produto/novo.twig", $dados);
	unset($dados['categorias']);
}