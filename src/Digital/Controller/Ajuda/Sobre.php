<?php 

include __DIR__ . '/../../../bootstrap.php';

echo $twig->render("ajuda/sobre.twig", $dados);
