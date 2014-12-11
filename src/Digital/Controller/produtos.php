<?php
use Digital\Service\ProdutoService;
use Digital\Database;

$produtos = new ProdutoService(new Database($driver));

echo $twig->render("produtos.twig",['menu'=>montaMenu($database),'ano'=>date('Y'),'produtos'=>$produtos->listar()]);