<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/lightning-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Lightning\Service;

use Daikon\Money\Service\PaymentServiceInterface;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Lightning\Entity\LightningInvoice;
use NGUtech\Lightning\ValueObject\Request;

interface LightningServiceInterface extends PaymentServiceInterface
{
    public function request(LightningInvoice $invoice): LightningInvoice;

    public function send(LightningInvoice $invoice): LightningInvoice;

    public function estimateFee(LightningInvoice $invoice): Bitcoin;

    public function decode(Request $request): LightningInvoice;

    public function getInfo(): array;
}
