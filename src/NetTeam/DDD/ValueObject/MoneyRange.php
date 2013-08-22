<?php

namespace NetTeam\DDD\ValueObject;

use NetTeam\DDD\ValueObject\Money;

/**
 * Range of money values.
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
final class MoneyRange extends Range
{
    /**
     * Static factory (ex. MoneyRange::USD(123.45, 456.78))
     *
     * @param $method
     * @param $arguments
     *
     * @return MoneyRange
     */
    public static function __callStatic($method, $arguments)
    {
        $min = null;
        $max = null;

        if (isset($arguments[0]) && null !== $arguments[0]) {
            $min = new Money($arguments[0], $method);
        }

        if (isset($arguments[1]) && null !== $arguments[1]) {
            $max = new Money($arguments[1], $method);
        }

        return new static($min, $max);
    }

    /**
     * Check if min and max are correct limits values and have same currencies,
     * then return currency of one.
     *
     * @return string
     */
    public function currency()
    {
        $this->assertCorrectLimits($this);

        if (null !== $this->min()) {
            return $this->min()->currency();
        }

        if (null !== $this->max()) {
            return $this->max()->currency();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function containsRange(Range $containedRange)
    {
        $this->assertCorrectLimits($this);
        $this->assertCorrectLimits($containedRange);

        $this->assertCorrectRangeType($containedRange);

        // check if current range is left-closed, and give is left-opened
        if (null !== $this->min() && null === $containedRange->min()) {
            return false;
        }

        // check if current lower limit is lower or equal than given lower limit
        if (null !== $this->min() && null !== $containedRange->min() && 1 === $this->min()->compareTo($containedRange->min())) {
            return false;
        }

        // check if current range is right-closed, and give is right-opened
        if (null !== $this->max() && null === $containedRange->max()) {
            return false;
        }

        // check if current upper limit is greater or equal than given upper limit
        if (null !== $this->max() && null !== $containedRange->max() && -1 === $this->max()->compareTo($containedRange->max())) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function assertCorrectLimitType($value)
    {
        if (null !== $value && !$value instanceof Money) {
            throw new \DomainException(sprintf('Value must be instance of NetTeam\DDD\ValueObject\Money or null, given instance of %s.', is_object($value) ? get_class($value) : gettype($value)));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function assertCorrectLimits(Range $range)
    {
        $this->assertCorrectLimitType($range->min());
        $this->assertCorrectLimitType($range->max());
        $this->assertSameCurrencies();
    }

    /**
     * Assert that min and max money objects have same currencies.
     *
     * @throws \DomainException
     */
    private function assertSameCurrencies()
    {
        if (null === $this->min() || null === $this->max()) {
            return;
        }

        if ($this->min()->currency() !== $this->max()->currency()) {
            throw new \DomainException(sprintf('Min and max objects must have same currencies, min is %s and max is %s', $this->min()->currency(), $this->max()->currency()));
        }
    }
}
