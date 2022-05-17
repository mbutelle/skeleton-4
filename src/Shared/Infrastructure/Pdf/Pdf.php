<?php

namespace App\Shared\Infrastructure\Pdf;

class Pdf extends \FPDI
{
    public function getLastPageNumber(): int {
        return \count($this->_importedPages) - 1;
    }
}