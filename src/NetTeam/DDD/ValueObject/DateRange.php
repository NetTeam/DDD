<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Zakres dat
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 */
class DateRange
{
    private $start;
    private $end;

    public function __construct(\DateTime $start, \DateTime $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}
