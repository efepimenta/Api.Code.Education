<?php

use Digital\Service\LoginService;
use Digital\Database;

if (!isset($_POST['controle'])){
	//volta para a pagina inicial
	header("Location:http://{$_SERVER['HTTP_HOST']}");
}

if ($_POST['controle'] === 'entrar'){
	//faz as coisas de entrar
	if ($loginService->login(new Database($driver), $_POST['login'], $_POST['senha'])){
		//devolve a pagina que o cabra tava
		header("Location:http://{$_SERVER['HTTP_HOST']}/{$_POST['uri']}");
	} else {
		echo $twig->render('login.erro.twig', $dados);
	}
} elseif ($_POST['controle'] === 'sair'){
	//faz as coisas de sair
	if ($loginService->logout()){
		//manda pra pagina de logout ok
		$dados['logado'] = false;
		echo $twig->render('logout.ok.twig', $dados);
	} else {
		echo $twig->render('logout.erro.twig', $dados);
	}
} else {
	//faz as coisas de tudo errado
	echo 'tudo errado';
}