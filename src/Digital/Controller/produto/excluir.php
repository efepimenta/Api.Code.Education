<?php
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;
$service = new ProdutoService($database);

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'excluir')) {
	
	$validator = new ProdutoValidator();
	if (! $validator->validar('deletar', $_POST['id'])) {
		$dados['erros'] = $validator->mensagemDeErro();
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