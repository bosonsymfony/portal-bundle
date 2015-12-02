<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TileRepository extends EntityRepository
{
    public function getAll()
    {
        $query = $this->_em->createQueryBuilder()
            ->select('tile', 'funcionalidad', 'contents', 'tileGroup')
            ->from('PortalBundle:Tile', 'tile')
            ->join('tile.funcionalidad', 'funcionalidad')
            ->leftJoin('tile.contents', 'contents')
            ->leftJoin('tile.tileGroup', 'tileGroup')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function get($id)
    {
        $query = $this->_em->createQueryBuilder()
            ->select('tile', 'funcionalidad', 'contents', 'tileGroup')
            ->from('PortalBundle:Tile', 'tile')
            ->join('tile.funcionalidad', 'funcionalidad')
            ->leftJoin('tile.contents', 'contents')
            ->leftJoin('tile.tileGroup', 'tileGroup')
            ->where("tile.id = $id")
            ->getQuery();

        $result = $query->getArrayResult();

        return (count($result) == 0) ? null : $result[0];
    }

    public function getFunctions()
    {
        $query = $this->_em->createQueryBuilder()
            ->select('funcionalidad')
            ->from('SeguridadBundle:Funcionalidad', 'funcionalidad')
            ->getQuery();

        $result = $query->getArrayResult();

        return $result;
    }
}
