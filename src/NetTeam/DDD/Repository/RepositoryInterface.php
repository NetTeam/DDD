<?php

namespace NetTeam\DDD\Repository;

interface RepositoryInterface
{
    public function persist($entity);

    public function remove($entity);
}
