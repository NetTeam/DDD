<?php

namespace NetTeam\DDD\Time;

/**
 * @author Piotr Walków <piotr.walkow@netteam.pl>
 */
class Clock implements ClockInterface
{
    /**
     * {@inheritdoc}
     */
    public function now()
    {
        return new \DateTime();
    }
}
