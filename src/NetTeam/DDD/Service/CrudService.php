<?php

namespace NetTeam\DDD\Service;

use NetTeam\DDD\Repository\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Implementacja CRUD
 */
class CrudService implements CrudServiceInterface
{

    private $class;
    private $entityManager;
    private $repository;
    private $repositoryMethods;

    /**
     * @param string              $class             FQN klasy
     * @param ObjectManager       $entityManager     manager encji
     * @param RepositoryInterface $entityManager     repozytorium
     * @param array               $repositoryMethods nazwy metod z repozytorium, ktore ma udostepniac serwis
     */
    public function __construct($class, ObjectManager $entityManager, RepositoryInterface $repository = null, $repositoryMethods = array())
    {
        $this->entityManager = $entityManager;
        $this->class = $class;
        $this->repository = $repository;
        $this->repositoryMethods = $repositoryMethods;
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @inheritdoc
     */
    public function update($entity)
    {
        $this->getRepository()->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function remove($entity)
    {
        $this->getRepository()->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Wykonuje metodę implementowaną przez repozytorium
     *
     * @param  string                  $name Nazwa metody
     * @param  array                   $args Argumenty dla wywoływanej metody
     * @return mixed
     * @throws \BadMethodCallException Wyjątek rzucany w przypadku, gdy repozytorium nie implementuje wywołanej metody
     */
    public function __call($name, $args)
    {
        if (in_array($name, $this->repositoryMethods)) {
            return call_user_func_array(array($this->getRepository(), $name), $args);
        }

        throw new \BadMethodCallException("Method $name doesn't exists or isn't enabled in service");
    }

    protected function getRepository()
    {
        if (null === $this->repository) {
            return $this->entityManager->getRepository($this->class);
        }

        return $this->repository;
    }

}
