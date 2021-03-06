<?php

namespace NetTeam\DDD\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Implementacja CRUD
 */
class CrudService implements CrudServiceInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var string[]
     */
    private $repositoryMethods;

    /**
     * @param string        $class             FQN klasy
     * @param ObjectManager $entityManager     manager encji
     * @param array         $repositoryMethods nazwy metod z repozytorium, ktore ma udostepniac serwis
     */
    public function __construct($class, ObjectManager $entityManager, $repositoryMethods = array())
    {
        $this->objectManager = $entityManager;
        $this->class = $class;
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
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @inheritdoc
     */
    public function update($entity)
    {
        $this->objectManager->persist($entity);
        $this->objectManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function remove($entity)
    {
        $this->objectManager->remove($entity);
        $this->objectManager->flush();
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

    /**
     * @return ObjectRepository
     */
    private function getRepository()
    {
        return $this->objectManager->getRepository($this->class);
    }
}
