<?php

use Digital\Service\CategoriaService;
use Digital\Service\Validator\CategoriaValidator;

$service = new CategoriaService();

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {

    $validator = new CategoriaValidator();
    if (!$validator->validar($em, 'atualizar', $_POST['id'], $_POST['nome'], $_POST['descricao'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('categoria/editar.incompleto.twig', $dados);
        exit();
    }

    $categoria = $validator->getCategoria();

    $categoria->setId($_POST['id']);
    $categoria->setNome($_POST['nome']);
    $categoria->setDescricao($_POST['descricao']);

    try {
        $result = $service->update($em, $categoria);
    } catch (Exception $e){
        die ($twig->render("categoria/editar.erro.twig", $dados));
    }

    if ($result) {
        echo $twig->render("categoria/editar.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("categoria/editar.erro.twig", $dados);
    }
} else {
    $dados['categorias'] = $service->findAll($em); //doctrine FAIO
// 	var_dump($dados['produtos']);exit;
    echo $twig->render("categoria/editar.twig", $dados);
    unset($dados['categorias']);
}