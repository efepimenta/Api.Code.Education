<?php
use Digital\Service\ProdutoService;
use Digital\Database;

$produtos = new ProdutoService(new Database($driver));

$dados['produtos'] = $produtos->listar();

echo $twig->render("produto.twig", $dados);