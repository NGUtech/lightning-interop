<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\ValueObject;

use Daikon\Interop\Assert;
use Daikon\Interop\Assertion;
use Daikon\Interop\MakeEmptyInterface;
use Daikon\ValueObject\ValueObjectInterface;

final class Request implements MakeEmptyInterface, ValueObjectInterface
{
    private ?string $request;

    /** @param string|null $value */
    public static function fromNative($value): self
    {
        //@todo improve request validation
        Assert::that($value, 'Must be a string.')->nullOr()->string()->notBlank();
        return new self($value);
    }

    public static function makeEmpty(): self
    {
        return new self;
    }

    public function isEmpty(): bool
    {
        return $this->request === null;
    }

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public function toNative(): ?string
    {
        return $this->request;
    }

    public function __toString(): string
    {
        return (string)$this->request;
    }

    private function __construct(?string $request = null)
    {
        $this->request = $request;
    }
}
