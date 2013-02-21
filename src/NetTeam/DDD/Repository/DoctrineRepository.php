<?php

namespace NetTeam\DDD\Repository;

use NetTeam\DDD\Repository\DoctrineRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Repozytorium opakowujące repozytoria Doctrine'owe
 * implementujące ObjectReposiotry.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class DoctrineRepository implements DoctrineRepositoryInterface
{

    private $manager;
    protected $repository;

    /**
     * @param  Doctrine\Common\Persistence\ManagerRegistry $registry
     * @param  string                                      $class    FQCN obiektu domenowego.
     * @throws \InvalidArgumentException                   Rzucany, gdy nie znaleziono menedżera dla klasy.
     */
    public function __construct(ManagerRegistry $registry, $class)
    {
        $this->manager = $registry->getManagerForClass($class);

        if (null === $this->manager) {
            throw new \InvalidArgumentException(sprintf("Manager supporting class %s not found.", $class));
        }

        $this->repository = $this->manager->getRepository($class);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function persist($entity)
    {
        $this->manager->persist($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        $this->manager->remove($entity);
    }

    public function createQueryBuilder($alias)
    {
        return $this->repository->createQueryBuilder($alias);
    }

    /**
     * Oddelegowanie zapytania do instancji repozytorium
     * implementującej ObjectRepository
     */
    public function __call($name, $args)
    {
        return call_user_func_array(array($this->repository, $name), $args);
    }

}
