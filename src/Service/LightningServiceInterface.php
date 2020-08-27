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
use NGUtech\Bitcoin\ValueObject\Hash;
use NGUtech\Lightning\Entity\LightningInvoice;
use NGUtech\Lightning\Entity\LightningPayment;
use NGUtech\Lightning\ValueObject\Request;

interface LightningServiceInterface extends PaymentServiceInterface
{
    public function request(LightningInvoice $invoice): LightningInvoice;

    public function send(LightningPayment $payment): LightningPayment;

    public function estimateFee(LightningPayment $payment): Bitcoin;

    public function decode(Request $request): LightningInvoice;

    //Using string param here because of differences in service impls
    public function getInvoice(string $preimageHash): ?LightningInvoice;

    public function getPayment(Hash $preimageHash): ?LightningPayment;

    public function getInfo(): array;
}
