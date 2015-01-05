<?php
/*
 * esse é o Controller Produto
 */
use Digital\Service\CategoriaService;

$categoria = new CategoriaService(); /* classe database sera removida */

$result = $categoria->findAll($em);

$dados['categorias'] = $result;

echo $twig->render("categoria.twig", $dados);