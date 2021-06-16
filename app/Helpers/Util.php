<?php

namespace App\Helpers;

class Util
{
    /**
     * @param float $grossPrice
     * @param float $vat
     * @return float
     */
    public static function removeVat(float $grossPrice, float $vat): float
    {
        return round($grossPrice / (1 + ($vat / 100)), 2);
    }
}