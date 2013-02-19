<?php

namespace NetTeam\DDD\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Interfejs dla repozytoriów
 */
interface RepositoryInterface extends ObjectRepository
{
    /**
     * Utrwalenie zmian encji w repozytorium
     *
     * @param mixed $entity
     */
    public function persist($entity);

    /**
     * Usunięcie encji z repozytorium
     *
     * @param mixed $entity
     */
    public function remove($entity);
}
