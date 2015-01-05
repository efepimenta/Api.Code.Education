<?php
use Digital\Service\CategoriaService;
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;

$cat = new CategoriaService();

if ((isset($_POST['acao'])) and ($_POST['acao'] === 'salvar')) {

    $validator = new ProdutoValidator();
    if (!$validator->validar($em, 'inserir', '', $_POST['nome'], $_POST['descricao'], $_POST['categoria'], $_POST['valor'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('produto/novo.incompleto.twig', $dados);
        exit();
    }

    $service = new ProdutoService($database);
    $produto = $validator->getProduto();

    $id = explode('-', $_POST['categoria']);

    $categoria = $cat->idPorDescricao($em, trim($id[1]));

    $produto->setId_categoria($categoria[0]);

    $result = $service->persist($em, $produto);
    if ($result) {
        echo $twig->render("produto/novo.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("produto/novo.erro.twig", $dados);
    }
} else {
    $dados['categorias'] = $cat->findAll($em);
    echo $twig->render("produto/novo.twig", $dados);
    unset($dados['categorias']);
}