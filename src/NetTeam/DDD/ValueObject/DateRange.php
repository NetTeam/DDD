<?php

namespace NetTeam\DDD\ValueObject;

/**
 * DateTime range.
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class DateRange extends Range
{

    /**
     * @return \DateTime|null
     *
     * @deprecated since version 1.1
     */
    public function getStart()
    {
        trigger_error('Method getStart() is deprecated since version 1.1 and will be removed in 1.2, use min() instead.', E_USER_DEPRECATED);

        return $this->min();
    }

    /**
     * @return \DateTime|null
     *
     * @deprecated since version 1.1
     */
    public function getEnd()
    {
        trigger_error('Method getEnd() is deprecated since version 1.1 and will be removed in 1.2, use max() instead.', E_USER_DEPRECATED);

        return $this->max();
    }

    protected function assertCorrectLimitType($value)
    {
        if (null !== $value && !$value instanceof \DateTime) {
            throw new \DomainException(sprintf('Value must be instance of \DateTime or null, given instance of %s.', is_object($value) ? get_class($value) : gettype($value)));
        }
    }
}
