<?php

namespace NetTeam\DDD\ValueObject;

/**
 * Range of numeric values.
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class Range
{
    /**
     * @var numeric
     */
    protected $min;

    /**
     * @var numeric
     */
    protected $max;

    /**
     * @param numeric $min
     * @param numeric $max
     */
    public function __construct($min = null, $max = null, $validate = true)
    {
        if ($validate) {
            $this->assertCorrectLimitType($min);
            $this->assertCorrectLimitType($max);

            $this->assertCorrectLimits($min, $max);
        }

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return numeric|null Range lower limit.
     */
    public function min()
    {
        return $this->min;
    }

    /**
     * @return numeric|null Range lower limit.
     *
     * @deprecated since version 1.1
     */
    public function getMin()
    {
        trigger_error('Method getMin() is deprecated since version 1.1 and will be removed in 1.2, use min() instead.', E_USER_DEPRECATED);

        return $this->min();
    }

    /**
     * @return numeric|null Range upper limit.
     */
    public function max()
    {
        return $this->max;
    }

    /**
     * @return numeric|null Range upper limit.
     *
     * @deprecated since version 1.1
     */
    public function getMax()
    {
        trigger_error('Method getMax() is deprecated since version 1.1 and will be removed in 1.2, use max() instead.', E_USER_DEPRECATED);

        return $this->max();
    }

    /**
     * Check if other range contains in current.
     *
     * @param  \NetTeam\DDD\ValueObject\Range $containedRange
     * @return boolean
     */
    public function containsRange($containedRange)
    {
        $this->assertCorrectRangeType($containedRange);

        // check if current range is left-closed, and give is left-opened
        if (null !== $this->min() && null === $containedRange->min()) {
            return false;
        }

        // check if current lower limit is lower or equal than given lower limit
        if (null !== $this->min() && null !== $containedRange->min() && $this->min() > $containedRange->min()) {
            return false;
        }

        // check if current range is right-closed, and give is right-opened
        if (null !== $this->max() && null === $containedRange->max()) {
            return false;
        }

        // check if current upper limit is greater or equal than given upper limit
        if (null !== $this->max() && null !== $containedRange->max() && $this->max() < $containedRange->max()) {
            return false;
        }

        return true;
    }

    /**
     * Check if numeric value contains in range.
     *
     * @param  numeric $value
     * @return boolean
     */
    public function contains($value)
    {
        $range = new static($value, $value);

        return $this->containsRange($range);
    }

    /**
     * Check if given value have correct type to be used as limit for this range.
     *
     * @param  mixed            $value
     * @throws \DomainException
     */
    protected function assertCorrectLimitType($value)
    {
        if (null !== $value && !is_numeric($value)) {
            throw new \DomainException(sprintf('Value must be numeric or null, given instance of %s.', is_object($value) ? get_class($value) : gettype($value)));
        }
    }

    /**
     * Check if given values can be limits for current range.
     *
     * @param  numeric          $min
     * @param  numeric          $max
     * @throws \DomainException
     */
    protected function assertCorrectLimits($min, $max)
    {
        if (null !== $min && null !== $max && $min > $max) {
            throw new \DomainException(sprintf('Lower limit cannot be greater than upper limit.'));
        }
    }

    /**
     * Check if given range is comparable to this one.
     *
     * @param  Range            $other
     * @throws \DomainException
     */
    protected function assertCorrectRangeType($other)
    {
        if (!$other instanceof static) {
            throw new \DomainException(sprintf('Compared range must be instance of %s, given instance of %s.', get_class($this), is_object($other) ? get_class($other) : gettype($other) ));
        }

        try {
            $this->assertCorrectLimitType($other->min());
            $this->assertCorrectLimitType($other->max());
        } catch (\DomainException $e) {
            throw new \DomainException(sprintf(
                    'Compared range limits must be numeric or null values, Given range with min and max of type %s and %s,', is_object($other->min()) ? get_class($other->min()) : gettype($other->min()), is_object($other->min()) ? get_class($other->min()) : gettype($other->min())
            ));
        }
    }
}
