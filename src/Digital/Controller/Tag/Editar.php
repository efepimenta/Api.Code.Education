<?php

use Digital\Service\TagService;
use Digital\Service\Validator\TagValidator;

$service = new TagService();

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {

    $validator = new TagValidator();
    if (!$validator->validar($em, 'atualizar', $_POST['id'], $_POST['nome'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('tag/editar.incompleto.twig', $dados);
        exit();
    }

    $tag = $validator->getTag();

    $tag->setId($_POST['id']);
    $tag->setTag($_POST['nome']);

    try {
        $result = $service->update($em, $tag);
    } catch (Exception $e){
        die ($twig->render("tag/editar.erro.twig", $dados));
    }

    if ($result) {
        echo $twig->render("tag/editar.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("tag/editar.erro.twig", $dados);
    }
} else {
    $dados['tags'] = $service->findAll($em); //doctrine FAIO
    echo $twig->render("tag/editar.twig", $dados);
}