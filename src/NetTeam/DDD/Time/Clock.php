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

    /**
     * {@inheritdoc}
     */
    public function firstDayOfMonth()
    {
        return new \DateTime('first day of this month');
    }
}
