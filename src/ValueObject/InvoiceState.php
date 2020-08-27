<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\ValueObject;

use Daikon\Interop\Assertion;
use Daikon\Interop\MakeEmptyInterface;
use Daikon\ValueObject\ValueObjectInterface;

final class InvoiceState implements MakeEmptyInterface, ValueObjectInterface
{
    public const PENDING = 'pending';
    public const SETTLED = 'settled';
    public const CANCELLED = 'cancelled';

    public const STATES = [
        self::PENDING,
        self::SETTLED,
        self::CANCELLED,
    ];

    private ?string $state;

    /** @param null|string $state */
    public static function fromNative($state): self
    {
        Assertion::nullOrString($state);
        return new self($state);
    }

    public function toNative(): ?string
    {
        return $this->state;
    }

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public static function makeEmpty(): self
    {
        return new self;
    }

    public function isEmpty(): bool
    {
        return $this->state === null;
    }

    public function isPending(): bool
    {
        return $this->state === self::PENDING;
    }

    public function isSettled(): bool
    {
        return $this->state === self::SETTLED;
    }

    public function isCancelled(): bool
    {
        return $this->state === self::CANCELLED;
    }

    public function __toString(): string
    {
        return (string)$this->state;
    }

    private function __construct(?string $state = null)
    {
        Assertion::nullOrinArray($state, self::STATES);
        $this->state = $state;
    }
}
