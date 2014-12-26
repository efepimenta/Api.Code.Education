<?php
/*
 * esse é o Controller Produto
 */
use Digital\Service\CategoriaService;
use Digital\Database;

$categoria = new CategoriaService(new Database($driver)); /* classe database sera removida */

$result = $categoria->findAll($em);

$dados['categorias'] = $result;

echo $twig->render("categoria.twig", $dados);