<?php
use Digital\Paginator;
use Digital\Service\CategoriaService;
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;

$cat = new CategoriaService();
$service = new ProdutoService();

/*
 * erros a serem corrigidos:
 * se eu editar a url e colocar um next que nao existe vai dar xabu
 */

$paginator = new Paginator();
$paginator->setAlvo('/produto/editar');

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'editar')) {

    $validator = new ProdutoValidator();

    // var_dump($_POST['categoria']);exit;
    if (!$validator->validar($em, 'atualizar', $_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['categoria'], $_POST['valor'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('produto/editar.incompleto.twig', $dados);
        exit();
    }
    
//     var_dump($validator);exit;

    $produto = $validator->getProduto();

    // $categoria = $cat->idPorDescricao($_POST['categoria'], true); //doctrine FAIO
    $categoria = $cat->idPorDescricao($em, $_POST['categoria'])[0]; // doctrine OK
//     $produto->setId($_POST['id']);
//     $produto->setNome($_POST['nome']);
//     $produto->setDescricao($_POST['descricao']);
    $produto->setId_categoria($categoria);
//     $produto->setValor($_POST['valor']);

    $result = $service->update($em, $produto);
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
    $dados['paginator'] = $paginator;
    $dados['produtos'] = $prod; // doctrine FAIO
    echo $twig->render("produto/editar.twig", $dados);
    unset($dados['categorias']);
    unset($dados['produtos']);
}