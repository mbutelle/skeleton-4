<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Message\Stock;

use App\Shared\Infrastructure\Message\MessageInterface;

final class StockMovement implements MessageInterface
{
    public ?string $receptionReference = null;

    public string $productReference;
    public string $siteReference;
    public string $labelReference;

    public \DateTime $expirationDate;

    public float $quantity;

    public \DateTime $createdAt;

    public function __construct(?string $receptionReference, string $productReference, string $siteReference, string $labelReference, \DateTime $expirationDate, float $quantity)
    {
        $this->receptionReference = $receptionReference;
        $this->productReference = $productReference;
        $this->siteReference = $siteReference;
        $this->labelReference = $labelReference;
        $this->expirationDate = $expirationDate;
        $this->quantity = $quantity;

        $this->createdAt = new \DateTime();
    }
}