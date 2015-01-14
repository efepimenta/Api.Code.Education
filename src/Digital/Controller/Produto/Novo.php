<?php
use Digital\Service\CategoriaService;
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;
use Digital\Service\TagService;

$cat = new CategoriaService();
$tags = new TagService();
$dados['tags'] = $tags->findAll($em);

if ((isset($_POST['acao'])) and ($_POST['acao'] === 'salvar')) {
    $t = '';
    foreach ($dados['tags'] as $tag){
        if (isset($_POST["tag{$tag->getId()}"])){
            $t = $t . $tag->getTag() . ';';
        }
    }
    $t = substr($t, 0, strlen($t)-1);

    $validator = new ProdutoValidator();
    if (!$validator->validar($em, 'inserir', '', $_POST['nome'], $_POST['descricao'], $_POST['categoria'], $_POST['valor'], $_FILES['imagem']['name'], $t)) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('produto/novo.incompleto.twig', $dados);
        exit();
    }
    
    $service = new ProdutoService();
    $produto = $validator->getProduto();

    $id = explode('-', $_POST['categoria']);

    $categoria = $cat->idPorDescricao($em, trim($id[1]));

    $produto->setIdCategoria($categoria[0]);

    try {
    $result = $service->persist($em, $produto);
    } catch (Exception $e){
        die ($twig->render("produto/novo.erro.twig", $dados));
    }

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