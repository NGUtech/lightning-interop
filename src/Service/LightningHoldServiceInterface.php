<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\Service;

use NGUtech\Lightning\Entity\LightningInvoice;

interface LightningHoldServiceInterface extends LightningServiceInterface
{
    public function settle(LightningInvoice $invoice): bool;

    public function cancel(LightningInvoice $invoice): bool;
}
