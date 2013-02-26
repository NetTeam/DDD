<?php

namespace NetTeam\DDD\Repository;

use NetTeam\DDD\Repository\ReadOnlyRepositoryInterface;

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
