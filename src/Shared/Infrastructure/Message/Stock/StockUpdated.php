<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Message\Stock;

use App\Shared\Infrastructure\Message\MessageInterface;

final class StockUpdated implements MessageInterface
{
    public string $productReference;
    public string $siteReference;
    public ?string $labelReference = null;
    public ?\DateTime $expirationDate = null;

    public float $quantity;

    public function __construct(string $productReference, string $siteReference, ?string $labelReference, ?\DateTime $expirationDate, float $quantity)
    {
        $this->productReference = $productReference;
        $this->siteReference = $siteReference;
        $this->labelReference = $labelReference;
        $this->expirationDate = $expirationDate;
        $this->quantity = $quantity;
    }
}