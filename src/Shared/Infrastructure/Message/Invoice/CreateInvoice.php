<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Message\Invoice;

use App\Shared\Infrastructure\Message\MessageInterface;

final class CreateInvoice implements MessageInterface
{
    public string $reference;
    public string $orderNumber;
    public \DateTime $orderDate;
    public \DateTime $date;
    public Address $invoiceAddress;
    public Address $deliveryAddress;

    /** @var Line[] */
    public array $lines;
}