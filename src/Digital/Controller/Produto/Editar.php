<?php
use Digital\Paginator;
use Digital\Service\CategoriaService;
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;
use Digital\Service\TagService;

$cat = new CategoriaService();
$service = new ProdutoService();
$tags = new TagService();
$dados['tags'] = $tags->findAll($em);
/*
 * erros a serem corrigidos:
 * se eu editar a url e colocar um next que nao existe vai dar xabu
 */

$paginator = new Paginator();
$paginator->setAlvo('/produto/editar');

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {
    $t = '';
    foreach ($dados['tags'] as $tag){
        if (isset($_POST["tag{$tag->getId()}"])){
            $t = $t . $tag->getTag() . ';';
        }
    }
    $t = substr($t, 0, strlen($t)-1);
    $validator = new ProdutoValidator();

    if (!$validator->validar($em, 'atualizar', $_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['categoria'], $_POST['valor'],$t)) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('produto/editar.incompleto.twig', $dados);
        exit();
    }
    
    $produto = $validator->getProduto();
    $categoria = $cat->idPorDescricao($em, $_POST['categoria'])[0]; // doctrine OK
    $produto->setIdCategoria($categoria);

    try {
        $result = $service->update($em, $produto);
    } catch (Exception $e){
        die ($twig->render("produto/editar.erro.twig", $dados));
    }

    defineBotoes($paginator);
    if ($result) {
        echo $twig->render("produto/editar.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("produto/editar.erro.twig", $dados);
    }
} else {
    $paginator->setBuscaCampo('*');
    $paginator->setPaginadorAtivo(true);
    $paginator->setRegistroAtual(1);
    if (isset($_GET['p'])) {
    	$paginator->setRegistroAtual ( $_GET ['pag'] );
        $paginator->setOffset($paginator->getQuantidadePorPagina () * ($paginator->getRegistroAtual () - 1));
        $paginator->setProximoRegistro($_GET['pag'] + 1);
    } else {
        $paginator->setOffset(0);
    }

    $dados['categorias'] = $cat->findAll($em); // doctrine OK
    /* formatar os valores */
    $tmp = $service->listaPaginada($em, $paginator);
    //adaptacao tecnica para a formatacao dos valores
    foreach ($tmp as $p) {
        $p->setValor(formatarValor($p->getValor()));
        $prod[$p->getId()] = $p;
    }
    defineBotoes($paginator);
    if (isset($prod)) {
        $dados ['produtos'] = $prod;
    } else {
        $paginator->setPaginadorAtivo(false);
    }
    $dados['paginator'] = $paginator;
    echo $twig->render("produto/editar.twig", $dados);
    unset($dados['categorias']);
    unset($dados['produtos']);
}