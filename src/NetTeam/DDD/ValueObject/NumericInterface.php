<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Numeric value
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 */
interface NumericInterface
{
    /**
     * @return float|integer
     */
    public function value();
}
