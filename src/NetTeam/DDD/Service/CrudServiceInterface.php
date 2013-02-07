<?php

namespace NetTeam\DDD\Service;

/**
 * Generyczny serwis CRUD
 */
interface CrudServiceInterface
{

    /**
     * Utworzenie nowego obiektu
     *
     * @return object
     */
    public function create();

    /**
     * Wyszukanie wg id
     *
     * @param  mixed  $id
     * @return object
     */
    public function find($id);

    /**
     * Zapisanie encji
     *
     * @param object $entity
     */
    public function update($entity);

    /**
     * Usuniecie encji
     *
     * @param object $entity
     */
    public function remove($entity);
}
