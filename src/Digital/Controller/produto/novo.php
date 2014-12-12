<?php
use Digital\Service\ProdutoService;
use Digital\Database;
use Digital\Entity\Produto;
use Digital\Service\CategoriaService;
use Digital\Service\Validator\ProdutoValidator;

$cat = new CategoriaService($database);

if ((isset($_POST['acao'])) and ($_POST['acao'] === 'salvar')) {
	
	$validator = new ProdutoValidator();
	if (! $validator->validar('inserir', '', $_POST['nome'], $_POST['descricao'], $_POST['categoria'], $_POST['valor']) ){
		$dados['erros'] = $validator->mensagemDeErro();
		echo $twig->render('produto/novo.incompleto.twig', $dados);
		exit();
	}
	
	$service = new ProdutoService($database);
	$produto = $validator->getProduto();
	
	$categoria = $cat->idPorDescricao($_POST['categoria'], true);
	$produto->setCategoria($categoria['id']);
	
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