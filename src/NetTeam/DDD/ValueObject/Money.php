<?php

namespace NetTeam\DDD\ValueObject;

use Doctrine\Common\Comparable;

/**
 * Value object representing money
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
class Money implements Comparable
{

    private $amount;
    private $currency;

    /**
     * @param  fload                     $amount
     * @param  string                    $currency
     * @throws \UnexpectedValueException Thrown when amount cannot be converted to float.
     */
    public function __construct($amount, $currency)
    {
        if (!is_numeric($amount)) {
            throw new \UnexpectedValueException(sprintf("Value must be convertable to float. Instance of %s given.", (is_object($amount) ? get_class($amount) : gettype($amount))));
        }

        $this->amount = (float) $amount;
        $this->currency = $currency;
    }

    /**
     * @return float Amount of money.
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return string Currency of money.
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function compareTo($other)
    {
        $this->assertInstanceOfMoney($other);
        $this->assertSameCurrency($other);

        if ($this->amount() < $other->amount()) {
            return -1;
        } elseif ($this->amount() === $other->amount()) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * Check if money values are equal.
     *
     * @param  \NetTeam\DDD\ValueObject\Money $other
     * @return boolean
     */
    public function equals(Money $other)
    {
        return 0 === $this->compareTo($other);
    }

    /**
     * Check if current money value is lower or equal than given.
     *
     * @param  \NetTeam\DDD\ValueObject\Money $other
     * @return boolean
     */
    public function lessOrEqualThan(Money $other)
    {
        return 1 > $this->compareTo($other);
    }

    /**
     * Check if current money value is greater or equal than given.
     *
     * @param  \NetTeam\DDD\ValueObject\Money $other
     * @return boolean
     */
    public function greaterOrEqualThan(Money $other)
    {
        return -1 < $this->compareTo($other);
    }

    /**
     * Assert that given object is instance of Money.
     *
     * @param  \NetTeam\DDD\ValueObject\Money $other
     * @throws \DomainException
     */
    private function assertInstanceOfMoney($other)
    {
        if (!$other instanceof Money) {
            throw new \DomainException(sprintf('Object must be instance of NetTeam\DDD\ValueObject\Money, instance of %s given.', is_object($other) ? get_class($other) : gettype($other)));
        }
    }

    /**
     * Assert that current and given money objects have same currencies.
     *
     * @param  \NetTeam\DDD\ValueObject\Money $other
     * @throws \DomainException
     */
    private function assertSameCurrency(Money $other)
    {
        if ($this->currency() !== $other->currency()) {
            throw new \DomainException(sprintf('Money object must have same currencies, current is %s and given %s', $this->currency(), $other->currency()));
        }
    }

}
