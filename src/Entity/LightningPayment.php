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
use Daikon\ValueObject\FloatValue;
use Daikon\ValueObject\Text;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\ValueObject\Hash;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Lightning\ValueObject\PaymentState;
use NGUtech\Lightning\ValueObject\Request;

final class LightningPayment extends Entity implements TransactionInterface
{
    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('preimage', Hash::class),
            Attribute::define('preimageHash', Hash::class),
            Attribute::define('request', Request::class),
            Attribute::define('destination', Text::class),
            Attribute::define('amount', Bitcoin::class),
            Attribute::define('feeLimit', FloatValue::class),
            Attribute::define('feeEstimate', Bitcoin::class),
            Attribute::define('feeSettled', Bitcoin::class),
            Attribute::define('label', Text::class),
            Attribute::define('description', Text::class),
            Attribute::define('state', PaymentState::class),
            Attribute::define('createdAt', Timestamp::class),
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

    public function getFeeLimit(): FloatValue
    {
        return $this->get('feeLimit') ?? FloatValue::zero();
    }

    public function getFeeEstimate(): Bitcoin
    {
        return $this->get('feeEstimate') ?? Bitcoin::makeEmpty();
    }

    public function getFeeSettled(): Bitcoin
    {
        return $this->get('feeSettled') ?? Bitcoin::makeEmpty();
    }

    public function getFeeRefund(): Bitcoin
    {
        return $this->getFeeEstimate()->subtract($this->getFeeSettled());
    }

    public function getLabel(): Text
    {
        return $this->get('label') ?? Text::makeEmpty();
    }

    public function getDescription(): Text
    {
        return $this->get('description') ?? Text::makeEmpty();
    }

    public function getState(): PaymentState
    {
        return $this->get('state') ?? PaymentState::makeEmpty();
    }

    public function getCreatedAt(): Timestamp
    {
        return $this->get('createdAt') ?? Timestamp::makeEmpty();
    }
}
