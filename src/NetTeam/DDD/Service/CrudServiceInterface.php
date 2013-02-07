<?php

namespace NetTeam\DDD\Service;

/**
 * Generyczny serwis CRUD
 */
interface CrudServiceInterface
{
    /**
     * Utworzenie nowego obiektu
     */
    public function create();

    /**
     * Wyszukanie wg id
     */
    public function find($id);

    /**
     * Zapisanie encji
     */
    public function update($entity);

    /**
     * Usuniecie encji
     */
    public function remove($entity);
}
