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

    /**
     * @return integer|float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return integer|float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Whether "this" contains whole given range
     *
     * @param  Range   $containedRange
     * @return Boolean
     */
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

    /**
     * Whether "this" contains given value
     *
     * @param  integer|float $value
     * @return Boolean
     */
    public function contains($value)
    {
        return ($value >= $this->min) && ($value <= $this->max);
    }
}
