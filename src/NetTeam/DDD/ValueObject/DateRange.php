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

    public function __construct(\DateTime $start = null, \DateTime $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \DateTime|null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTime|null
     */
    public function getEnd()
    {
        return $this->end;
    }
}
