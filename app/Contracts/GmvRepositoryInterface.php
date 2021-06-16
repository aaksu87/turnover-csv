<?php

namespace App\Contracts;

interface GmvRepositoryInterface
{
    /**
     * @param array $brands
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getTurnoverData(array $brands, string $startDate, string $endDate): array;
}