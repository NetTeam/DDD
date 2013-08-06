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
     * @param  numeric                   $percent
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
     * @return float Percent value.
     */
    public function get()
    {
        return $this->percent;
    }

    /**
     * @return float Percent value converted to scalar unit.
     */
    public function scalar()
    {
        return $this->get() / 100;
    }

}
