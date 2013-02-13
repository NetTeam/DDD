<?php

namespace NetTeam\DDD\Repository;

use NetTeam\DDD\Repository\RepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @author Paweł A. Wacławczyk <pawel.waclawczyk@netteam.pl>
 */
class ORMRepository extends EntityRepository implements RepositoryInterface
{

    public function persist($entity)
    {
        $this->_em->persist($entity);
    }

    public function remove($entity)
    {
        $this->_em->remove($entity);
    }

}
