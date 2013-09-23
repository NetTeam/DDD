<?php

namespace NetTeam\DDD\Time;

/**
 * Factory dla obiektów DateTime
 *
 * Między innymi aby można było testować
 * jednostkowo operacje na klasie DateTime
 *
 * @author Piotr Walków <piotr.walkow@netteam.pl>
 */
interface ClockInterface
{
    /**
     * Pobiera aktualną datę
     *
     * @return \DateTime
     */
    public function now();
}
