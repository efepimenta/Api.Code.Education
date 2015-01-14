<?php
use Digital\Service\TagService;
use Digital\Service\Validator\TagValidator;

$tag = new TagService();

if ((isset($_POST['acao'])) and ($_POST['acao'] === 'salvar')) {

    $validator = new TagValidator();
    if (!$validator->validar($em, 'inserir', '', $_POST['nome'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('tag/novo.incompleto.twig', $dados);
        exit();
    }

    $service = new TagService();
    $tag = $validator->getTag();

    try {
        $result = $service->persist($em, $tag);
    } catch (Exception $e){
        die ($twig->render("tag/novo.erro.twig", $dados));
    }

    if ($result) {
        echo $twig->render("tag/novo.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("tag/novo.erro.twig", $dados);
    }
} else {
    $dados['tags'] = $tag->findAll($em);
    echo $twig->render("tag/novo.twig", $dados);
}