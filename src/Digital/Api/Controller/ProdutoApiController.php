<?php
namespace Digital\Api\Controller;

use Symfony\Component\HttpFoundation\Request;

class ProdutoApiController
{

    public function getController($app)
    {
        $produto = $app['controllers_factory'];
        
        $service = $app['produtoservice'];
        $validator = $app['produtovalidator'];
        
        $produto->get("/", function () use($app, $service)
        {
            
            foreach ($service->findAll($app['em']) as $res) {
                $result[$res->getId()]['nome'] = $res->getNome();
                $result[$res->getId()]['descricao'] = $res->getDescricao();
                $result[$res->getId()]['valor'] = 'R$ ' . formatarValor($res->getValor());
                $result[$res->getId()]['categoria'] = $res->getCategoriaAsJson();
                $result[$res->getId()]['tags'] = $res->getTagsAsJson();
            }
            if (isset($result)) {
                return $app->json($result);
            }
            return $app->json('Nenhum produto encontrado');
        });
        
        $produto->get("/{id}", function ($id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'listar', $id)) {
                return $app->json($validator->mensagemDeErro());
            }
            $produto = $service->find($app['em'], $id);
            
            if (! isset($produto)) {
                return $app->json('Produto não encontrado');
            }
            
            $result['nome'] = $produto->getNome();
            $result['descricao'] = $produto->getDescricao();
            $result['valor'] = 'R$ ' . formatarValor($produto->getValor());
            $result['categoria'] = $produto->getCategoriaAsJson();
            $result['tags'] = $produto->getTagsAsJson();
            return $app->json($result);
        });
        
        $produto->post("/", function (Request $request) use($app, $service, $validator)
        {
            
            $cat = $request->get('categoria');
            if (is_null($cat)) {
                return $app->json('Categoria não informada');
            }
            
            if (! $validator->validar($app['em'], 'inserir', '', $request->get('nome'), $request->get('descricao'), $cat, $request->get('valor'),'',$request->get('tags'))) {
                return $app->json($validator->mensagemDeErro());
            }
            $result = $service->persist($app['em'], $validator->getProduto());
            
            if ($result) {
                return $app->json("Produto ID {$validator->getProduto()->getId()} inserido com sucesso");
            }
            return $app->json($result);
        });
        
        $produto->put("/{id}", function (Request $request, $id) use($app, $service, $validator)
        {
            
            $cat = $request->get('categoria');
            if (is_null($cat)) {
                return $app->json('Categoria não informada');
            }
            if (! $validator->validar($app['em'], 'atualizar', $id, $request->get('nome'), $request->get('descricao'), $cat, $request->get('valor'),'',$request->get('tags'))) {
                return $app->json($validator->mensagemDeErro());
            }
            $prod = $validator->getProduto();
            try {
                $result = $service->update($app['em'], $prod);
            } catch (Exception $e) {
                return $app->json('Erro ao atualizar produto ou produto não encontrado');
            }
            if ($result) {
                return $app->json('Produto atualizado com sucesso');
            }
            return $app->json('Erro ao atualizar produto ou produto não encontrado');
        });
        
        $produto->delete("/{id}", function (Request $request, $id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'deletar', $id)) {
                return $app->json($validator->mensagemDeErro());
            }
            $result = $service->remove($app['em'], $validator->getProduto());
            if ($result) {
                return $app->json('Produto excluido com sucesso');
            } else {
                return $app->json("Nenhum produto encontrado com o id {$id}");
            }
            return $app->json($result);
        });
        
        return $produto;
    }
}