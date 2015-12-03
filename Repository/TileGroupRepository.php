<?php

namespace UCI\Boson\PortalBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * TileGroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TileGroupRepository extends EntityRepository
{
    public function getAll()
    {
        $query = $this->_em->createQueryBuilder()
            ->select('tileGroup')
            ->from('PortalBundle:TileGroup', 'tileGroup')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function get($id)
    {
        $query = $this->_em->createQueryBuilder()
            ->select('tileGroup')
            ->from('PortalBundle:TileGroup', 'tileGroup')
            ->where("tileGroup.id = $id")
            ->getQuery();

        $result = $query->getArrayResult();

        return (count($result) == 0) ? null : $result[0];
    }

    public function getAllTiles($funcionalidades)
    {
        if (count($funcionalidades) > 0) {

            $qb = $this->_em->createQueryBuilder();

            $qb->select('tg', 't', 'c', 'f', 'a')
                ->from('PortalBundle:TileGroup', 'tg')
                ->leftJoin('tg.myTiles', 't')
                ->leftJoin('t.contents', 'c')
                ->join('t.funcionalidad', 'f')
                ->join('f.accion', 'a');

            $index = 1;
            foreach ($funcionalidades as $key => $value) {
                $qb->orWhere($qb->expr()->eq('a.firma', '?' . $index))
                    ->setParameter($index, $value['firma']);
                $index++;
            }
            return $qb->getQuery()->getArrayResult();
        }
        return array();
    }

//    public function getAllTiles()
//    {
//        $qb = $this->_em->createQueryBuilder();
//
//        $qb->select('tg', 't', 'c', 'l')
//            ->from('PortalBundle:TileGroup', 'tg')
//            ->leftJoin('tg.myTiles', 't')
//            ->leftJoin('t.contents', 'c')
//            ->leftJoin('t.live', 'l');
////            ->where('t.route is not null');
//
//        return $qb->getQuery()->getArrayResult();
//    }
}
