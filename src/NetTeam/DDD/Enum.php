<?php

namespace NetTeam\DDD;

use Doctrine\Common\Inflector\Inflector;

abstract class Enum
{

    protected $value;

    const __NULL = null;

    public function __construct($value, $validate = true)
    {
        if ($validate && !$this->isValid($value)) {
            throw new \UnexpectedValueException(sprintf('Given value "%s" is invalid', $value));
        }

        $this->value = $value;
    }

    /**
     * @return mixed
     */
    final public function get()
    {
        return $this->value;
    }

    /**
     * Checks if $value is equal to value in enum
     *
     * @param  mixed   $value
     * @return Boolean
     */
    final public function is($value)
    {
        return $value === $this->value;
    }

    /**
     * Checks if value in enum is equal to $enum
     *
     * @param  Enum    $enum
     * @return Boolean
     */
    final public function equals(Enum $enum)
    {
        return $enum->get() === $this->get();
    }

    /**
     * Checks if $valuesList contains enum value
     *
     * @param  array   $valuesList
     * @return Boolean
     */
    final public function isOneOf(array $valuesList)
    {
        foreach ($valuesList as $val) {
            if ($this->value === $val) {
                return true;
            }
        }

        return false;
    }

    protected function isValid($value)
    {
        $refl = new \ReflectionClass($this);

        return in_array($value, array_values($refl->getConstants()));
    }

    public function __toString()
    {
        $refl = new \ReflectionClass($this);

        $className = $refl->getShortName();
        $constName = '';

        foreach ($refl->getConstants() as $const => $value) {
            if ($value === $this->value) {
                $constName = $const;
                break;
            }
        }

        return Inflector::camelize($className) . "." . Inflector::camelize(strtolower($constName));
    }

}
