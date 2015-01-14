<?php
use Digital\Service\TagService;
/*
 * esse é o Controller Tag
 */

$tag = new TagService();

$result = $tag->findAll($em);

$dados['tags'] = $result;

echo $twig->render("tag.twig", $dados);