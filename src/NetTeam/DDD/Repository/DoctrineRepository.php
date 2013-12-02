<?php

namespace NetTeam\DDD\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use NetTeam\DDD\Repository\DoctrineRepositoryInterface;

/**
 * Repozytorium opakowujące repozytoria Doctrine'owe
 * implementujące ObjectReposiotry.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class DoctrineRepository implements DoctrineRepositoryInterface
{
    private $manager;
    private $autoflush;
    protected $repository;

    /**
     * @param  Doctrine\Common\Persistence\ManagerRegistry $registry
     * @param  string                                      $class     FQCN obiektu domenowego.
     * @param  boolean                                     $autoflush Flush after every add or remove action.
     * @throws \InvalidArgumentException                   Rzucany, gdy nie znaleziono menedżera dla klasy.
     */
    public function __construct($registry, $class, $autoflush = false)
    {
        /**
         * Fix dla BC BREAK w DoctrineBridge pomiędzy wersjami 2.0 a 2.1.
         * W 2.1 wprowadzono standardowy interface z Doctrine Common.
         */
        if ($registry instanceof ManagerRegistry) {
            $this->manager = $registry->getManagerForClass($class);
        } else {
            $this->manager = $registry->getEntityManagerForClass($class);
        }

        if (null === $this->manager) {
            throw new \InvalidArgumentException(sprintf("Manager supporting class %s not found.", $class));
        }

        $this->repository = $this->manager->getRepository($class);
        $this->autoflush = $autoflush;
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

        if (true === $this->autoflush) {
            $this->manager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        $this->manager->remove($entity);

        if (true === $this->autoflush) {
            $this->manager->flush();
        }
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
