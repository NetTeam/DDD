<?php

namespace NetTeam\DDD;

abstract class Enum
{
    private $value;

    const __NULL = null;

    public function __construct($value, $validate = true)
    {
        if ($validate && !$this->isValid($value)) {
            throw new \UnexpectedValueException(sprintf('Given value "%s" is invalid', $value));
        }

        $this->value = $value;
    }

    final public function get()
    {
        return $this->value;
    }

    final public function is($value)
    {
        return $value === $this->value;
    }

    final public function equals(Enum $enum)
    {
        return $enum->get() === $this->get();
    }

    final public function isOneOf(array $valuesList)
    {
        foreach ($valuesList as $val) {
            if ($this->value === $val) {
                return true;
            }
        }

        return false;
    }

    private function isValid($value)
    {
        $refl = new \ReflectionClass($this);

        return in_array($value, array_values($refl->getConstants()));
    }
}
