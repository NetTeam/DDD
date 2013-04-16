<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Obiekt przechowujacy kwoty pieniężne.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class Money
{

    private $value;
    private $currency;

    public function __construct($value, $currency)
    {
        if (!is_numeric($value)) {
            throw new \UnexpectedValueException(sprintf("Value must be convertable to float. Instance of %s given.", (is_object($value) ? get_class($value) : gettype($value))));
        }

        $this->value = (float) $value;
        $this->currency = $currency;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function __toString()
    {
        return sprintf("%.2f %s", $this->value, $this->currency);
    }

}
