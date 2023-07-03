<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    private $isNewSituations = [
        0 => 'Not New',
        1 => 'New',
    ];

    private $showStockCountsSituations = [
        0 => 'Hide Stock Counts',
        1 => 'Show Stock Counts',
    ];

    /**
     * @return string[]
     */
    public function getIsNewSituations(): array
    {
        return $this->isNewSituations;
    }

    /**
     * @return string[]
     */
    public function getShowStockCountsSituations(): array
    {
        return $this->showStockCountsSituations;
    }
}
