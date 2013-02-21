<?php

namespace NetTeam\DDD\Repository;

use NetTeam\DDD\Repository\RepositoryInterface;

/**
 * Interfejs repozytoriów doctrine'owych, dostarczajacych dodatkowych funkcjonalności,
 * poza zdeklarowanymi w ObjectRepository.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
interface DoctrineRepositoryInterface extends RepositoryInterface
{

    /**
     * Utworzenie QueryBuildera
     *
     * @param string $alias
     */
    public function createQueryBuilder($alias);
}
