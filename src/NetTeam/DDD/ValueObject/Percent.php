<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Object representing percent value.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class Percent
{
    /**
     * @var float
     */
    private $percent;

    /**
     * @param  numeric                   $percent Fractional value of percent (ex. .45 means 45%)
     * @throws \UnexpectedValueException
     */
    public function __construct($percent)
    {
        if (!is_numeric($percent)) {
            throw new \UnexpectedValueException(sprintf("Percent value must be convertable to float. Instance of %s given.", (is_object($percent) ? get_class($percent) : gettype($percent))));
        }

        $this->percent = (float) $percent;
    }

    /**
     * @return float Fractional percent value.
     */
    public function value()
    {
        return $this->percent;
    }
}
