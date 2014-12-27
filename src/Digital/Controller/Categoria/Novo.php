<?php
use Digital\Database;
use Digital\Service\CategoriaService;
use Digital\Service\Validator\CategoriaValidator;

$cat = new CategoriaService();

if ((isset($_POST['acao'])) and ($_POST['acao'] === 'salvar')) {
	
	$validator = new CategoriaValidator();
	if (! $validator->validar($em,'inserir', '', $_POST['nome'], $_POST['descricao']) ){
		$dados['erros'] = $validator->mensagemDeErro();
		echo $twig->render('categoria/novo.incompleto.twig', $dados);
		exit();
	}
	
	$service = new CategoriaService($database);
	$categoria = $validator->getCategoria();
	
	$result = $service->persist($em, $categoria);
	if ($result) {
		echo $twig->render("categoria/novo.ok.twig", $dados);
	}
	else {
		$dados['erros'] = $result;
		echo $twig->render("categoria/novo.erro.twig", $dados);
	}
}
else {
	$dados['categorias'] = $cat->findAll($em);
	echo $twig->render("categoria/novo.twig", $dados);
	unset($dados['categorias']);
}