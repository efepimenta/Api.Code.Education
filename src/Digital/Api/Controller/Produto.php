<?php
use Symfony\Component\HttpFoundation\Request;

$produto = $app['controllers_factory'];

$service = $app['service'];
$validator = $app['validator'];

$produto->get("/", function () use($app, $service) {
	
	foreach ( $service->findAll($app['em']) as $res ) {
		$result[]['nome'] = $res->getNome();
		$result[]['descricao'] = $res->getDescricao();
		$result[]['valor'] = $res->getValor();
		$cat = $res->getId_categoria();
		$result[]['categoria'] = "ID: {$cat->getId()} - Desc: {$cat->getDescricao()}";
	}
	
	return $app->json($result);
});

$produto->get("/{id}", function ($id) use($app, $service, $validator) {
	
	if (! $validator->validar($app['em'],'listar', $id)) {
		return $app->json($validator->mensagemDeErro());
	}
	$produto = $service->find($app['em'], $id);
	
	if (! isset($produto)) {
		return $app->json('Produto não encontrado');
	}
	
	$result['nome'] = $produto->getNome();
	$result['descricao'] = $produto->getDescricao();
	$result['valor'] = $produto->getValor();
	$cat = $produto->getId_categoria();
	$result['categoria'] = "ID: {$cat->getId()} - Desc: {$cat->getDescricao()}";
	return $app->json($result);
});

$produto->post("/", function (Request $request) use($app, $service, $validator) {
	
	if (! $validator->validar($app['em'],'inserir', '', $request->get('nome'), $request->get('descricao'), $request->get('categoria'), $request->get('valor'))) {
		return $app->json($validator->mensagemDeErro());
	}
	// if ($service->inserir($validator->getProduto())) {
	$return = $service->persist($app['em'], $validator->getProduto());
	if ($return) {
		return $app->json('Produto inserido com sucesso');
	}
	return $app->json($return);
});

$produto->put("/{id}", function (Request $request, $id) use($app, $service, $validator) {
	
	if (! $validator->validar($app['em'],'atualizar', $id, $request->get('nome'), $request->get('descricao'), $request->get('categoria'), $request->get('valor'))) {
		return $app->json($validator->mensagemDeErro());
	}
	// if ($service->atualizar($validator->getProduto())) {
	$return = $service->update($app['em'], $validator->getProduto());
	if ($return) {
		return $app->json('Produto atualizado com sucesso');
	}
	return $app->json('Erro ao atualizar produto ou produto não encontrado');
});

$produto->delete("/{id}", function (Request $request, $id) use($app, $service, $validator) {
	
	if (! $validator->validar($app['em'],'deletar', $id)) {
		return $app->json($validator->mensagemDeErro());
	}
	// if ($service->deletar($id)) {
	$return = $service->remove($app['em'], $validator->getProduto());
	if ($return) {
		return $app->json('Produto excluido com sucesso');
	}
	else {
		return $app->json("Nenhum produto encontrado com o id {$id}");
	}
	return $app->json($return);
});

return $produto;