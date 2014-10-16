<?php

namespace NetTeam\DDD\Repository;

/**
 * Interfejs dla repozytoriów
 */
interface RepositoryInterface extends ReadOnlyRepositoryInterface
{

    /**
     * Utrwalenie zmian encji w repozytorium
     *
     * @param object $entity
     */
    public function persist($entity);

    /**
     * Usunięcie encji z repozytorium
     *
     * @param object $entity
     */
    public function remove($entity);
}
