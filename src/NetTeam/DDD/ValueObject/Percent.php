<?php

namespace NetTeam\DDD\ValueObject;

use Doctrine\Common\Comparable;

/**
 * Object representing percent value.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class Percent implements NumericInterface, Comparable
{
    /**
     * @var float
     */
    private $percent;

    /**
     * @param  integer|float             $percent Fractional value of percent (ex. .45 means 45%)
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

    /**
     * {@inheritdoc}
     */
    public function compareTo($other)
    {
        if (!$other instanceof Percent) {
            throw new \DomainException(sprintf('Object must be instance of NetTeam\DDD\ValueObject\Percent, instance of %s given.', is_object($other) ? get_class($other) : gettype($other)));
        }

        if ($this->value() < $other->value()) {
            return -1;
        } elseif ($this->value() === $other->value()) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * Check if two percents are equal.
     *
     * @param Percent $other
     *
     * @return boolean
     */
    public function equals(Percent $other)
    {
        return 0 === $this->compareTo($other);
    }

    /**
     * Check if current percent is less or equal than given
     *
     * @param Percent $other
     *
     * @return boolean
     */
    public function lessOrEqualThan(Percent $other)
    {
        return 1 > $this->compareTo($other);
    }

    /**
     * Check if current percent is greater or equal than given
     *
     * @param Percent $other
     *
     * @return boolean
     */
    public function greaterOrEqualThan(Percent $other)
    {
        return -1 < $this->compareTo($other);
    }
}
