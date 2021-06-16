<?php

namespace App\Contracts;

interface BrandRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllBrands(): array;
}