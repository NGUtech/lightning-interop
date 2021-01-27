<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\Entity;

use Daikon\Entity\Attribute;
use Daikon\Entity\AttributeMap;
use Daikon\Entity\Entity;
use Daikon\Money\Entity\TransactionInterface;
use Daikon\ValueObject\Natural;
use Daikon\ValueObject\Text;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\Service\SatoshiCurrencies;
use NGUtech\Bitcoin\ValueObject\Hash;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Lightning\ValueObject\InvoiceState;
use NGUtech\Lightning\ValueObject\Request;

final class LightningInvoice extends Entity implements TransactionInterface
{
    public const AMOUNT_MIN = '1'.SatoshiCurrencies::MSAT;
    public const AMOUNT_MAX = '4294967295'.SatoshiCurrencies::MSAT;

    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('preimage', Hash::class),
            Attribute::define('preimageHash', Hash::class),
            Attribute::define('request', Request::class),
            Attribute::define('destination', Text::class),
            Attribute::define('amount', Bitcoin::class),
            Attribute::define('amountPaid', Bitcoin::class),
            Attribute::define('label', Text::class),
            Attribute::define('description', Text::class),
            Attribute::define('expiry', Natural::class),
            Attribute::define('cltvExpiry', Natural::class),
            Attribute::define('blockHeight', Natural::class),
            Attribute::define('state', InvoiceState::class),
            Attribute::define('createdAt', Timestamp::class),
            Attribute::define('settledAt', Timestamp::class),
        ]);
    }

    public function getIdentity(): Hash
    {
        return $this->getPreimageHash();
    }

    public function getPreimage(): Hash
    {
        return $this->get('preimage') ?? Hash::makeEmpty();
    }

    public function getPreimageHash(): Hash
    {
        return $this->get('preimageHash') ?? Hash::makeEmpty();
    }

    public function getRequest(): Request
    {
        return $this->get('request') ?? Request::makeEmpty();
    }

    public function getDestination(): Text
    {
        return $this->get('destination') ?? Text::makeEmpty();
    }

    public function getAmount(): Bitcoin
    {
        return $this->get('amount') ?? Bitcoin::makeEmpty();
    }

    public function getAmountPaid(): Bitcoin
    {
        return $this->get('amountPaid') ?? Bitcoin::makeEmpty();
    }

    public function getLabel(): Text
    {
        return $this->get('label') ?? Text::makeEmpty();
    }

    public function getDescription(): Text
    {
        return $this->get('description') ?? Text::makeEmpty();
    }

    public function getExpiry(): Natural
    {
        return $this->get('expiry') ?? Natural::fromNative(86400);
    }

    public function getCltvExpiry(): Natural
    {
        return $this->get('cltvExpiry') ?? Natural::fromNative(10);
    }

    public function getBlockHeight(): Natural
    {
        return $this->get('blockHeight') ?? Natural::makeEmpty();
    }

    public function getExpiryHeight(): Natural
    {
        //@todo handle error cases
        return $this->getBlockHeight()->add($this->getCltvExpiry());
    }

    public function getState(): InvoiceState
    {
        return $this->get('state') ?? InvoiceState::makeEmpty();
    }

    public function getCreatedAt(): Timestamp
    {
        return $this->get('createdAt') ?? Timestamp::makeEmpty();
    }

    public function getExpiresAt(): Timestamp
    {
        return $this->getCreatedAt()->modify("+{$this->getExpiry()} seconds");
    }

    public function hasExpired(Timestamp $time): bool
    {
        return $this->getExpiresAt()->isBefore($time);
    }

    public function getSettledAt(): Timestamp
    {
        return $this->get('settledAt') ?? Timestamp::makeEmpty();
    }
}
