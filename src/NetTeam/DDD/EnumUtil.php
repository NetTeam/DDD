<?php

namespace NetTeam\DDD;

use Doctrine\Common\Inflector\Inflector;

/**
 * @author Paweł A. Wacławczyk <pawel.waclawczyk@netteam.pl>
 */
class EnumUtil
{

    public static function getAvailableValues($enumObjectOrClass)
    {
        if (is_object($enumObjectOrClass)) {
            $enumObjectOrClass = get_class($enumObjectOrClass);
        }

        $refl = new \ReflectionClass($enumObjectOrClass);

        return $refl->getConstants();
    }

    public static function createChoiceList($enumObjectOrClass, $prefix = null)
    {
        if (is_object($enumObjectOrClass)) {
            $enumObjectOrClass = get_class($enumObjectOrClass);
        }

        $refl = new \ReflectionClass($enumObjectOrClass);

        $values = $refl->getConstants();

        if (null === $prefix) {
            $prefix = Inflector::camelize($refl->getShortName());
        }

        $choices = array();

        foreach ($values as $const => $value) {
            if ('__' === substr($const, 0, 2)) {
                continue;
            }

            $choices[$value] = $prefix . "." . Inflector::camelize(strtolower($const));
        }

        return $choices;
    }

    private function __construct()
    {

    }

}
