<?php
namespace Digital\Service;

use Doctrine\ORM\EntityManager;
use Digital\DatabaseDoctrine;

class MenuService extends DatabaseDoctrine
{

    private $class;

    public function __construct()
    {
        
        /* classe que o doctrine vai mapear */
        $this->class = 'Digital\Entity\Menu';
        parent::setClass($this->class);
    }

    /**
     * Monta um menu estilo bootstrap com os dados da tabela
     *
     * @param EntityManager $em            
     */
    function montaMenu(EntityManager $em)
    {
        $rotaservice = new RotaService();
        $rp = $em->getRepository($this->class);
        foreach ($rp->montaMenu() as $mnu) {
            $menu[$mnu->getId()]['nome'] = $mnu->getNome();
            $menu[$mnu->getId()]['kind'] = $mnu->getKind();
            $menu[$mnu->getId()]['sequencia'] = $mnu->getSequencia();
            $menu[$mnu->getId()]['posicao'] = $mnu->getPosicao();
            $menu[$mnu->getId()]['imagem'] = $mnu->getImagem();
            $menu[$mnu->getId()]['fim'] = $mnu->getFim();
            // tratamento se a rota estivre vazia
            $rota = $rotaservice->uriPorId($em, $mnu->getIdRota());
            if (\count($rota)) {
                $menu[$mnu->getId()]['rota'] = $rota[0]->getRota();
            } else {
                $menu[$mnu->getId()]['rota'] = '#';
            }
        }
        return $menu;
    }
}