<?php
use Digital\Service\ProdutoService;
use Digital\Database;
use Digital\Entity\Produto;
use Symfony\Component\HttpFoundation\Request;

$produto = $app['controllers_factory'];

$service = new ProdutoService($database);

$produto->get("/", function () use($app, $service) {
	
	return $app->json($service->listar());
});
$produto->get("/{id}", function ($id) use($app, $service) {
	// sua lógica para listar o produto de ID $id
	return $app->json($service->listarPorId($id));
});
$produto->post("/", function (Request $request) use($app, $service) {
	if ((empty($request->get('nome'))) || (empty($request->get('descricao'))) || (empty($request->get('categoria'))) || (empty($request->get('valor')))) {
		return $app->json('Faltando informacoes', 200);
	}
	
	$produto = new Produto();
	$produto->setId($service->nextID());
	$produto->setNome($request->get('nome'));
	$produto->setDescricao($request->get('descricao'));
	$produto->setCategoria($request->get('categoria'));
	$produto->setValor($request->get('valor'));
	
	if ($service->inserir($produto)) {
		return $app->json('Produto inserido com sucesso');
	}
	return $app->json('Erro ao inserir produto', 200);
});
$produto->put("/{id}", function (Request $request, $id) use($app, $service) {
	if ((empty($request->get('id'))) || (empty($request->get('nome'))) || (empty($request->get('descricao'))) || (empty($request->get('categoria'))) || (empty($request->get('valor')))) {
		return $app->json('Faltando informacoes', 200);
	}
	
	$produto = new Produto();
	$produto->setId($id);
	$produto->setNome($request->get('nome'));
	$produto->setDescricao($request->get('descricao'));
	$produto->setCategoria($request->get('categoria'));
	$produto->setValor($request->get('valor'));
	
	if ($service->atualizar($produto)) {
		return $app->json('Produto atualizado com sucesso');
	}
	return $app->json('Erro ao atualizar produto', 200);
});
$produto->delete("/{id}", function (Request $request, $id) use($app, $service) {
	if ((empty($request->get('id')))) {
		return $app->json('Faltando informacoes', 200);
	}
	
	if ($service->deletar($id)) {
		return $app->json('Produto excluido com sucesso');
	}
	return $app->json('Erro ao excluir produto', 200);
});

return $produto;