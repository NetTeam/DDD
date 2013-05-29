<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Klucz - wartość
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 */
class KeyValue
{
    private $key;
    private $value;

    /**
     * @param mixed $key   Klucz
     * @param mixed $value Wartość
     */
    public function __construct($key = null, $value = null)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * Klucz
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Wartość
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}
