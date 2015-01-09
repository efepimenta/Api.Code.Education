<?php
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;
use Digital\Paginator;

$service = new ProdutoService();

if ((isset($_POST['acao'])) && ($_POST['acao'] === 'excluir')) {

    $validator = new ProdutoValidator();
    if (!$validator->validar($em, 'deletar', $_POST['id'])) {
        $dados['erros'] = $validator->mensagemDeErro();
        echo $twig->render('produto/excluir.incompleto.twig', $dados);
        exit();
    }

    $produto = $validator->getProduto();

    try {
    $result = $service->remove($em, $produto);
    } catch (Exception $e){
        die ($twig->render("produto/excluir.erro.twig", $dados));
    }

    if ($result) {
        echo $twig->render("produto/excluir.ok.twig", $dados);
    } else {
        $dados['erros'] = $result;
        echo $twig->render("produto/excluir.erro.twig", $dados);
    }
} else {
	$paginator = new Paginator();
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
	
    $prods = $service->listaPaginada($em, $paginator);
    //adaptacao tecnica para a formatacao dos valores
    foreach ($prods as $p) {
        $p->setValor(formatarValor($p->getValor()));
        $prod[$p->getId()] = $p;
    }
    $dados['produtos'] = $prod;
    defineBotoes($paginator);
    $dados['paginator'] = $paginator;
    echo $twig->render("produto/excluir.twig", $dados);
    unset($dados['produtos']);
}