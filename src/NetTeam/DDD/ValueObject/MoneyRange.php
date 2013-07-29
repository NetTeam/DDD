<?php

namespace NetTeam\DDD\ValueObject;

use NetTeam\DDD\ValueObject\Money;

/**
 * Range of money values.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class MoneyRange extends Range
{

    /**
     * {@inheritdoc}
     */
    protected function assertCorrectLimitType($value)
    {
        if (null !== $value && !$value instanceof Money) {
            throw new \DomainException(sprintf('Value must be instance of NetTeam\DDD\ValueObject\Money or null, given instance of %s.', is_object($value) ? get_class($value) : gettype($value)));
        }
    }

    protected function assertCorrectLimits($min, $max)
    {
        if (null !== $min && null !== $max && 1 === $min->compareTo($max)) {
            throw new \DomainException(sprintf('Lower limit cannot be greater than upper limit.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function containsRange($containedRange)
    {
        if (null !== $this->min() && null === $containedRange->min()) {
            return false;
        }

        if (null !== $this->min() && null !== $containedRange->min() && 1 === $this->min()->compareTo($containedRange->min())) {
            return false;
        }

        if (null !== $this->max() && null === $containedRange->max()) {
            return false;
        }

        if (null !== $this->max() && null !== $containedRange->max() && -1 === $this->max()->compareTo($containedRange->max())) {
            return false;
        }

        return true;
    }

}
