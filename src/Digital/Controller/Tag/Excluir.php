<?php
use Digital\Service\TagService;
use Digital\Service\Validator\TagValidator;

$service = new TagService();

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'excluir')) {

    $validator = new TagValidator();
    if (!$validator->validar($em, 'deletar', $_POST['id'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('tag/excluir.incompleto.twig', $dados);
        exit();
    }

    $tag = $validator->getTag();

    try {
        $result = $service->remove($em, $tag);
    } catch (Exception $e) {
        die ($twig->render("tag/excluir.erro.twig", $dados));
    }
    if ($result) {
        echo $twig->render("tag/excluir.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("tag/excluir.erro.twig", $dados);
    }
} else {
    $dados['tags'] = $service->findAll($em); //doctrine FAIO
    echo $twig->render("tag/excluir.twig", $dados);
}