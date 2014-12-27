<?php
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;
use Digital\Service\CategoriaService;
use Doctrine\DBAL\Types\VarDateTimeType;

$service = new ProdutoService();

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'excluir')) {
	
	$validator = new ProdutoValidator();
	if (! $validator->validar($em,'deletar', $_POST['id'])) {
		$dados['erros'] = $validator->mensagemDeErro();
		echo $twig->render('produto/excluir.incompleto.twig', $dados);
		exit();
	}
	
	$produto = $validator->getProduto();
	
	// if ($service->deletar($_POST['id'])) {
	$result = $service->remove($em, $produto);
	if ($result) {
		echo $twig->render("produto/excluir.ok.twig", $dados);
	}
	else {
		$dados['erros'] = $result;
		echo $twig->render("produto/excluir.erro.twig", $dados);
	}
}
else {
	$dados['produtos'] = $service->findAll($em); //doctrine FAIO
	echo $twig->render("produto/excluir.twig", $dados);
	unset($dados['produtos']);
}