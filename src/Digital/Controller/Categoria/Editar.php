<?php

use Digital\Service\CategoriaService;
use Digital\Entity\Produto;
use Digital\Service\Validator\CategoriaValidator;

$service = new CategoriaService($database);

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {

	$validator = new CategoriaValidator();
	if (! $validator->validar($em,'atualizar', $_POST['id'], $_POST['nome'], $_POST['descricao']) ){
		$dados['erros'] = $validator->mensagemDeErro();
		echo $twig->render('categoria/editar.incompleto.twig', $dados);
		exit();
	}


	$categoria = $validator->getCategoria();

	$categoria->setId($_POST['id']);
	$categoria->setNome($_POST['nome']);
	$categoria->setDescricao($_POST['descricao']);

	$result = $service->update($em, $categoria);
	if ($result) {
		echo $twig->render("categoria/editar.ok.twig", $dados);
	}
	else {
		$dados['erros'] = $result;
		echo $twig->render("categoria/editar.erro.twig", $dados);
	}
}
else {
	$dados['categorias'] = $service->findAll($em); //doctrine FAIO
// 	var_dump($dados['produtos']);exit;
	echo $twig->render("categoria/editar.twig", $dados);
	unset($dados['categorias']);
}