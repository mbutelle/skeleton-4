<?php

declare(strict_types=1);


namespace App\Shared\Infrastructure\Message\Invoice;


final class Line
{
    public int $quantity;
    public float $unitPrice;
    public string $description;
}