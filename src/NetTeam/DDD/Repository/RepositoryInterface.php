<?php

namespace NetTeam\DDD\Repository;

/**
 * Interfejs dla repozytoriów
 */
interface RepositoryInterface
{

    /**
     * Wyszukanie encji po identyfikatorze.
     *
     * @param  mixed       $id
     * @return null|object
     */
    public function find($id);

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
