<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Zakres wartości
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 */
class Range
{
    private $min;
    private $max;

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function containsRange(Range $containedRange)
    {
        // starts before min
        if ($this->min > $containedRange->getMin()) {
            return false;
        }
        // ends after max
        if ($this->max < $containedRange->getMax()) {
            return false;
        }

        return true;
    }

    public function contains($value)
    {
        return ($value >= $this->min) && ($value <= $this->max);
    }
}
