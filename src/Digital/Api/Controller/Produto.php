<?php

$app->get("/produtos", function() use($app) {
	// sua lógica para listar todos os produtos
	return $app->json(lista_de_produtos);
});
$app->get("/produtos/{id}", function($id) use($app) {
	// sua lógica para listar o produto de ID $id
	return $app->json(produto);
});
$app->post("/produtos", function(Request $request) use($app) {
	// sua lógica para inserir 1 novo registro
	return $app->json(registro_inserido);
});
$app->put("/produtos/{id}", function(Request $request, $id) use($app) {
	// sua lógica para editar o produto de ID $id
	return $app->json(registro_editado);
});
$app->delete("/produtos/{id}", function($id) use($app) {
	// sua lógica para apagar o produto de ID $id
	return $app->json(apagado);
});