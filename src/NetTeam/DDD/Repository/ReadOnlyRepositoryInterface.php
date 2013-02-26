<?php

namespace NetTeam\DDD\Repository;

/**
 * Interfejs dla repozytoriów tylko do odczytu.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
interface ReadOnlyRepositoryInterface
{

    /**
     * Wyszukanie encji po identyfikatorze.
     *
     * @param  mixed       $id
     * @return null|object
     */
    public function find($id);
}
