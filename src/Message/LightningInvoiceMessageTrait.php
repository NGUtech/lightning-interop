<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\Message;

use Daikon\Interop\Assertion;
use Daikon\ValueObject\IntValue;
use Daikon\ValueObject\Text;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Bitcoin\ValueObject\Hash;

trait LightningInvoiceMessageTrait
{
    private Hash $preimage;

    private Hash $preimageHash;

    private ?Text $request;

    private ?Text $label;

    private ?Bitcoin $amount;

    private ?Bitcoin $amountPaid;

    private ?Timestamp $timestamp;

    private ?IntValue $cltvExpiry;

    /** @param array $state */
    public static function fromNative($state): self
    {
        Assertion::isArray($state);
        Assertion::keyExists($state, 'preimageHash');

        return new self(
            Hash::fromNative($state['preimage'] ?? null),
            Hash::fromNative($state['preimageHash']),
            $state['request'] ? Text::fromNative($state['request']) : null,
            $state['label'] ? Text::fromNative($state['label']) : null,
            $state['amount'] ? Bitcoin::fromNative($state['amount']) : null,
            $state['amountPaid'] ? Bitcoin::fromNative($state['amountPaid']) : null,
            $state['timestamp'] ? Timestamp::fromNative($state['timestamp']) : null,
            $state['cltvExpiry'] ? IntValue::fromNative($state['cltvExpiry']) : null
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

    public function getRequest(): ?Text
    {
        return $this->request;
    }

    public function getLabel(): ?Text
    {
        return $this->label;
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

    public function getCltvExpiry(): ?IntValue
    {
        return $this->cltvExpiry;
    }

    public function toNative(): array
    {
        return [
            'preimage' => $this->preimage->toNative(),
            'preimageHash' => $this->preimageHash->toNative(),
            'request' => $this->request ? (string)$this->request : null,
            'label' => $this->label ? (string)$this->label : null,
            'amount' => $this->amount ? $this->amount->toNative() : null,
            'amountPaid' => $this->amountPaid ? $this->amountPaid->toNative() : null,
            'timestamp' => $this->timestamp ? (string)$this->timestamp : null,
            'cltvExpiry' => $this->cltvExpiry ? $this->cltvExpiry->toNative() : null
        ];
    }

    private function __construct(
        Hash $preimage,
        Hash $preimageHash,
        Text $request = null,
        Text $label = null,
        Bitcoin $amount = null,
        Bitcoin $amountPaid = null,
        Timestamp $timestamp = null,
        IntValue $cltvExpiry = null
    ) {
        $this->preimage = $preimage;
        $this->preimageHash = $preimageHash;
        $this->request = $request;
        $this->label = $label;
        $this->amount = $amount;
        $this->amountPaid = $amountPaid;
        $this->timestamp = $timestamp;
        $this->cltvExpiry = $cltvExpiry;
    }
}
