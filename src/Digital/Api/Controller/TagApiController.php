<?php
namespace Digital\Api\Controller;

use Symfony\Component\HttpFoundation\Request;

class TagApiController
{

    public function getController($app)
    {
        $tag = $app['controllers_factory'];
        
        $service = $app['tagservice'];
        $validator = $app['tagvalidator'];
        
        $tag->get("/", function () use($app, $service)
        {
            
            foreach ($service->findAll($app['em']) as $res) {
                $result[$res->getId()]['tag'] = $res->getTag();
            }
            if (isset($result)) {
                return $app->json($result);
            }
            return $app->json('Nenhuma Tag encontrada');
        });
        
        $tag->get("/{id}", function ($id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'listar', $id)) {
                return $app->json($validator->mensagemDeErro());
            }
            $tag = $service->find($app['em'], $id);
            
            if (! isset($tag)) {
                return $app->json('Tag não encontrada');
            }
            
            $result['tag'] = $tag->getTag();
            return $app->json($result);
        });
        
        $tag->post("/", function (Request $request) use($app, $service, $validator)
        {
            
            $cat = $request->get('tag');
            if (is_null($cat)) {
                return $app->json('Nome da tag não informado');
            }
            
            if (! $validator->validar($app['em'], 'inserir', '', $request->get('tag'))) {
                return $app->json($validator->mensagemDeErro());
            }
            
            $result = $service->persist($app['em'], $validator->getTag());
            if ($result) {
                return $app->json("Tag ID {$validator->getTag()->getId()} inserida com sucesso");
            }
            return $app->json($result);
        });
        
        $tag->put("/{id}", function (Request $request, $id) use($app, $service, $validator)
        {
            
            $cat = $request->get('tag');
            if (is_null($cat)) {
                return $app->json('Tag não informada');
            }
            if (! $validator->validar($app['em'], 'atualizar', $id, $request->get('tag'))) {
                return $app->json($validator->mensagemDeErro());
            }
            $tag = $validator->getTag();
            try {
                $result = $service->update($app['em'], $tag);
            } catch (Exception $e) {
                return $app->json('Erro ao atualizar Tag ou Tag não encontrada');
            }
            if ($result) {
                return $app->json('Tag atualizada com sucesso');
            }
            return $app->json('Erro ao atualizar Tag ou Tag não encontrada');
        });
        
        $tag->delete("/{id}", function (Request $request, $id) use($app, $service, $validator)
        {
            
            if (! $validator->validar($app['em'], 'deletar', $id)) {
                return $app->json($validator->mensagemDeErro());
            }
            $result = $service->remove($app['em'], $validator->getTag());
            if ($result) {
                return $app->json('Tag excluida com sucesso');
            } else {
                return $app->json("Nenhuma tag encontrada com o id {$id}");
            }
            return $app->json($result);
        });
        
        return $tag;
    }
}