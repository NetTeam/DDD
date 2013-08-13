<?php

namespace NetTeam\DDD\ValueObject;

use Doctrine\Common\Comparable;

/**
 * Value object representing money
 *
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 */
final class Money implements Comparable
{
    const DEFAULT_SCALE = 4;
    const ROUDING_MODE  = PHP_ROUND_HALF_UP;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var int
     */
    private $scale;

    /**
     * @param float  $amount
     * @param string $currency
     * @param int    $scale
     *
     * @throws \UnexpectedValueException Thrown when amount cannot be converted to float.
     */
    public function __construct($amount, $currency, $scale = self::DEFAULT_SCALE)
    {
        if (!is_numeric($amount)) {
            throw new \UnexpectedValueException(sprintf("Value must be convertable to float. Instance of %s given.", (is_object($amount) ? get_class($amount) : gettype($amount))));
        }

        $this->scale = $scale;

        $this->amount = $this->round($amount, $this->scale);
        $this->currency = $currency;
    }

    /**
     * Static factory (ex. Money::USD(123.45))
     *
     * @param $method
     * @param $arguments
     *
     * @return Money
     */
    public static function __callStatic($method, $arguments)
    {
        if (isset($arguments[1])) {
            return new static($arguments[0], $method, $arguments[1]);
        }

        return new static($arguments[0], $method);
    }

    /**
     * @return numeric Amount of money.
     */
    public function amount()
    {
        return $this->round($this->amount, 2);
    }

    /**
     * @return float Raw amount of money.
     */
    public function amountRaw()
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

        if ($this->amount < $other->amount) {
            return -1;
        } elseif ($this->amount === $other->amount) {
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
     * Add two Money values
     *
     * @param Money $money
     *
     * @return Money
     */
    public function add(Money $money)
    {
        $this->assertSameCurrency($money);

        $scale = max($this->scale, $money->scale);

        return new static(bcadd($this->amount, $money->amount, $scale), $this->currency, $scale);
    }

    /**
     * Subtract two Money values
     *
     * @param Money $money
     *
     * @return Money
     */
    public function subtract(Money $money)
    {
        $this->assertSameCurrency($money);

        $scale = max($this->scale, $money->scale);

        return new static(bcsub($this->amount, $money->amount, $scale), $this->currency, $scale);
    }

    /**
     * Multiply Money value
     *
     * @param integer|float|NumericInterface $multiplier
     * @param int|null                       $scale
     *
     * @return Money
     */
    public function multiply($multiplier, $scale = null)
    {
        if ($multiplier instanceof NumericInterface) {
            $multiplier = $multiplier->value();
        }

        $this->assertOperand($multiplier);

        return new static(bcmul($this->amount, $multiplier, $this->scale), $this->currency, $scale ?: $this->scale);
    }

    /**
     * Divide Money value
     *
     * @param integer|float|Money $divisor
     * @param int|null            $scale
     *
     * @return Money|Percent
     */
    public function divide($divisor, $scale = null)
    {
        if ($divisor instanceof Money) {
            $this->assertSameCurrency($divisor);

            $scale = $scale ?: $this->scale + $divisor->scale;

            return bcdiv($this->amount, $divisor->amount, $scale);
        }

        if ($divisor instanceof NumericInterface) {
            $divisor = $divisor->value();
        }

        $this->assertOperand($divisor);

        return new static(bcdiv($this->amount, $divisor, $this->scale), $this->currency, $scale ?: $this->scale);
    }

    /**
     * @return bool
     */
    public function isZero()
    {
        return 0.0 === $this->amount;
    }

    /**
     * @return bool
     */
    public function isPositive()
    {
        return $this->amount > 0;
    }

    /**
     * @return bool
     */
    public function isNegative()
    {
        return $this->amount < 0;
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

    /**
     * Assert if operand is correct type
     *
     * @throws \DomainException
     */
    private function assertOperand($operand)
    {
        if (!is_int($operand) && !is_float($operand)) {
            throw new \DomainException('Operand should be an integer or a float');
        }
    }

    /**
     * Rounding value with given scale
     *
     * @param $value
     * @param $scale
     *
     * @return float
     */
    private function round($value, $scale)
    {
        return round((float) $value, $scale, self::ROUDING_MODE);
    }
}
