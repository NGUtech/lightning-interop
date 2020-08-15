<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\Message;

use Daikon\Interop\Assertion;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Bitcoin\ValueObject\Hash;

trait LightningPaymentMessageTrait
{
    private Hash $preimage;

    private Hash $preimageHash;

    private ?Bitcoin $amount;

    private ?Bitcoin $amountPaid;

    private ?Timestamp $timestamp;

    /** @var array $state */
    public static function fromNative($state): self
    {
        Assertion::isArray($state);
        Assertion::keyExists($state, 'preimage');
        Assertion::keyExists($state, 'preimageHash');

        return new self(
            Hash::fromNative($state['preimage']),
            Hash::fromNative($state['preimageHash']),
            $state['amount'] ? Bitcoin::fromNative($state['amount']) : null,
            $state['amountPaid'] ? Bitcoin::fromNative($state['amountPaid']) : null,
            $state['timestamp'] ? Timestamp::fromNative($state['timestamp']) : null,
        );
    }

    public function getPreimage(): Hash
    {
        return $this->preimage;
    }

    public function getPreimageHash(): Hash
    {
        return $this->preimageHash;
    }

    public function getAmount(): ?Bitcoin
    {
        return $this->amount;
    }

    public function getAmountPaid(): ?Bitcoin
    {
        return $this->amountPaid;
    }

    public function getTimestamp(): ?Timestamp
    {
        return $this->timestamp;
    }

    public function toNative(): array
    {
        return [
            'preimage' => $this->preimage->toNative(),
            'preimageHash' => $this->preimageHash->toNative(),
            'amount' => $this->amount ? $this->amount->toNative() : null,
            'amountPaid' => $this->amountPaid ? $this->amountPaid->toNative() : null,
            'timestamp' => $this->timestamp ? (string)$this->timestamp : null,
        ];
    }

    private function __construct(
        Hash $preimage,
        Hash $preimageHash,
        Bitcoin $amount = null,
        Bitcoin $amountPaid = null,
        Timestamp $timestamp = null
    ) {
        $this->preimage = $preimage;
        $this->preimageHash = $preimageHash;
        $this->amount = $amount;
        $this->amountPaid = $amountPaid;
        $this->timestamp = $timestamp;
    }
}
