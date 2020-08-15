<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\Message;

use Daikon\ValueObject\IntValue;
use Daikon\ValueObject\Text;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Bitcoin\ValueObject\Hash;

interface LightningInvoiceMessageInterface extends LightningMessageInterface
{
    public function getPreimage(): Hash;

    public function getPreimageHash(): Hash;

    public function getRequest(): ?Text;

    public function getLabel(): ?Text;

    public function getAmount(): ?Bitcoin;

    public function getAmountPaid(): ?Bitcoin;

    public function getTimestamp(): ?Timestamp;

    public function getCltvExpiry(): ?IntValue;
}
