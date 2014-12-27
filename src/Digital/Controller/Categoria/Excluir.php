<?php
use Digital\Service\CategoriaService;
use Digital\Service\Validator\CategoriaValidator;

$service = new CategoriaService();

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'excluir')) {
	
	$validator = new CategoriaValidator();
	if (! $validator->validar($em,'deletar', $_POST['id'])) {
		$dados['erros'] = $validator->mensagemDeErro();
		echo $twig->render('categoria/excluir.incompleto.twig', $dados);
		exit();
	}
	
	$categoria = $validator->getCategoria();
	
	// if ($service->deletar($_POST['id'])) {
	
	$result = $service->remove($em, $categoria);
	if ($result) {
		echo $twig->render("categoria/excluir.ok.twig", $dados);
	}
	else {
		$dados['erros'] = $result;
		echo $twig->render("categoria/excluir.erro.twig", $dados);
	}
}
else {
	$dados['categorias'] = $service->findAll($em); //doctrine FAIO
	echo $twig->render("categoria/excluir.twig", $dados);
	unset($dados['categorias']);
}