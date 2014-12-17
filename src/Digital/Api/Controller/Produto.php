<?php
use Symfony\Component\HttpFoundation\Request;

$produto = $app['controllers_factory'];

$service = $app['service'];
$validator = $app['validator'];

$produto->get("/", function () use($app, $service) {
	
	return $app->json($service->listar());
});

$produto->get("/{id}", function ($id) use($app, $service, $validator) {
	
	if (! $validator->validar('listar', $id)) {
		return $app->json($validator->mensagemDeErro());
	}
	$produto = $service->listarPorId($id);
	return $app->json($produto);
});

$produto->post("/", function (Request $request) use($app, $service, $validator) {
	
	if (! $validator->validar('inserir', '', $request->get('nome'), $request->get('descricao'), $request->get('categoria'), $request->get('valor'))) {
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
	
	if (! $validator->validar('atualizar', $id, $request->get('nome'), $request->get('descricao'), $request->get('categoria'), $request->get('valor'))) {
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
	
	if (! $validator->validar('deletar', $id)) {
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