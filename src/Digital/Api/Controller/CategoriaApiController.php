<?php
namespace Digital\Api\Controller;

use Symfony\Component\HttpFoundation\Request;

class CategoriaApiController
{

    public function getController($app)
    {
        $categoria = $app['controllers_factory'];
        
        $service = $app['categoriaservice'];
        $validator = $app['categoriavalidator'];
        
        $categoria->get("/", function () use($app, $service)
        {
            
            foreach ($service->findAll($app['em']) as $res) {
                $result[$res->getId()]['nome'] = $res->getNome();
                $result[$res->getId()]['descricao'] = $res->getDescricao();
            }
            if (isset($result)) {
                return $app->json($result);
            }
            return $app->json('Nenhuma categoria encontrada');
        });
        
        $categoria->get("/{id}", function ($id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'listar', $id)) {
                return $app->json($validator->mensagemDeErro());
            }
            $cat = $service->find($app['em'], $id);
            
            if (! isset($cat)) {
                return $app->json('Categoria não encontrada');
            }
            
            $result['id'] = $cat->getId();
            $result['nome'] = $cat->getNome();
            $result['descricao'] = $cat->getDescricao();
            return $app->json($result);
        });
        
        $categoria->post("/", function (Request $request) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'inserir', '', $request->get('nome'), $request->get('descricao'))) {
                return $app->json($validator->mensagemDeErro());
            }
            
            $result = $service->persist($app['em'], $validator->getCategoria());
            if ($result) {
                return $app->json('Categoria inserida com sucesso');
            }
            return $app->json($result);
        });
        
        $categoria->put("/{id}", function (Request $request, $id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'atualizar', $id, $request->get('nome'), $request->get('descricao'))) {
                return $app->json($validator->mensagemDeErro());
            }
            
            $result = $service->update($app['em'], $validator->getCategoria());
            if ($result) {
                return $app->json('Categoria atualizada com sucesso');
            }
            return $app->json('Erro ao atualizar categoria ou categoria não encontrada');
        });
        
        $categoria->delete("/{id}", function (Request $request, $id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'deletar', $id)) {
                return $app->json($validator->mensagemDeErro());
            }
            
            $result = $service->remove($app['em'], $validator->getCategoria());
            if ($result) {
                return $app->json('Categoria excluida com sucesso');
            } else {
                return $app->json("Nenhuma categoria encontrado com o id {$id}");
            }
            return $app->json($result);
        });
        
        return $categoria;
    }
}