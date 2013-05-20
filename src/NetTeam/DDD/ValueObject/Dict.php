<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Wartość słownikowa
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 */
class Dict
{
    private $key;
    private $value;

    /**
     * @param mixed $key   Klucz
     * @param mixed $value Wartość
     */
    public function __construct($key, $value)
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
