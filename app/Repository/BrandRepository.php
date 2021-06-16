<?php

namespace App\Repository;

use App\Contracts\BrandRepositoryInterface;
use App\Helpers\Database;
use App\Model\Brand;

class BrandRepository extends Database implements BrandRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllBrands(): array
    {
        return Brand::all()->sortBy('id')->toArray();
    }
}