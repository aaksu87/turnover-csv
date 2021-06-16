<?php

namespace App\Repository;

use App\Contracts\GmvRepositoryInterface;
use App\Helpers\Database;
use App\Model\Gmv;

class GmvRepository extends Database implements GmvRepositoryInterface
{
    const VAT = 21;

    /**
     * @param array $brands
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getTurnoverData(array $brands, string $startDate, string $endDate): array
    {
        $select[] = 'gmv.date AS date';
        foreach ($brands as $brand) {
            $select[] = "SUM(CASE WHEN gmv.brand_id=" . $brand['id'] . " THEN gmv.turnover END) AS '" . $brand['name'] . "'";
        }
        $select[] = 'SUM(gmv.turnover) AS total_daily';

        return Gmv::query()
            ->selectRaw(implode(', ', $select))
            ->leftJoin('brands', 'gmv.brand_id', '=', 'brands.id')
            ->whereBetween('gmv.date', [$startDate, $endDate])
            ->groupBy('gmv.date')
            ->orderBy('gmv.date')
            ->get()->toArray();
    }
}