<?php

echo $twig->render("produtos/novo.twig",['menu'=>montaMenu($database),'ano'=>date('Y')]);