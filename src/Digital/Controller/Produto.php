<?php
/*
 * esse é o Controller Produto
 */
use Digital\Paginator;
use Digital\Service\ProdutoService;

$service = new ProdutoService (); /* classe database sera removida */

$paginator = new Paginator ();
$paginator->setPaginadorAtivo ( true );
$paginator->setAlvo ( 'produto' );

/*
 * tipos de entrada:
 * -> pelo link produtos
 * -> pelo botao buscar
 * -> pelo paginador
 */
/* a variavel p indica que o paginador foi clicado */
if (isset ( $_GET ['p'] )) {
	
	/* campo como * indica que o cliente pediu uma listagem de todos os produtos */
	if ($_GET ['campo'] == '*') {
		$paginator->setBuscaCampo ( '*' );
		$paginator->setOffset ( (($_GET ['pag'] -1) * $paginator->getQuantidadePorPagina ()) );
		$paginator->setRegistroAtual($_GET['pag']);
		$paginator->setProximoRegistro($_GET['pag'] + 1);
		$result = $service->listaPaginada ( $em, $paginator );
		defineBotoes ( $paginator );
	} else {
		/* campo diferente de * indica que a busca foi acionada */
		$paginator->setBuscaCampo ( $_GET ['campo'] );
		$paginator->setBuscaCriterio ( $_GET ['criterio'] );
		$paginator->setBuscaTermo ( $_GET ['termo'] );
		if ($_GET ['quantidade'] != '' ){
			$qtde = $_GET ['quantidade'];
		} else {
			$qtde = POR_PAGINA;
		}
		$paginator->setQuantidadePorPagina ( $qtde );
		if ($_GET ['pag'] == '') {
			$paginator->setRegistroAtual ( 1 );
			$paginator->setProximoRegistro ( 2 );
		} else {
			$paginator->setRegistroAtual ( $_GET ['pag'] );
			$paginator->setProximoRegistro ( $paginator->getRegistroAtual () + 1 );
			$paginator->setOffset ( $paginator->getQuantidadePorPagina () * ($paginator->getRegistroAtual () - 1) );
		}
		$result = $service->buscaPersonalizada ( $em, $paginator );
		defineBotoes ( $paginator );
	}
} else {
	/* p nao existe e paginador inicial é montado */
	$paginator->setRegistroAtual ( 1 );
	$paginator->setBuscaCampo ( '*' );
	$result = $service->listaPaginada ( $em, $paginator );
	defineBotoes ( $paginator );
}

foreach ( $result as $p ) {
	$p->setValor ( formatarValor ( $p->getValor () ) );
	$prod [$p->getId ()] = $p;
}

$dados ['produtos'] = $prod;
$dados ['paginator'] = $paginator;

echo $twig->render ( "produto.twig", $dados );