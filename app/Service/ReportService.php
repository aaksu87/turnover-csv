<?php

namespace App\Service;

use App\Contracts\BrandRepositoryInterface;
use App\Contracts\CsvServiceInterface;
use App\Contracts\GmvRepositoryInterface;
use App\Helpers\Util;
use App\Repository\GmvRepository;

class ReportService
{
    private static array $brands;

    public function __construct(
        private BrandRepositoryInterface $brandRepository,
        private GmvRepositoryInterface $gmvRepository,
        private CsvServiceInterface $csvService,
    )
    {
        self::$brands = $this->brandRepository->getAllBrands();
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return string
     * @throws \Exception
     */
    public function exportTurnoverCsv($startDate, $endDate): string
    {
        $data = $this->gmvRepository->getTurnoverData(self::$brands, $startDate, $endDate);

        if (!count($data)) {
            throw new \Exception('No record found');
        }

        $csvData = self::prepareTurnoverData($data);

        $fileName = 'Turnover_' . date("Y-m-d", strtotime($startDate)) . '_' . date("Y-m-d", strtotime($endDate)) . '.csv';

        return $this->csvService
            ->setFileName($fileName)
            ->exportCsv($csvData);
    }

    /**
     * @param $data
     * @return array
     */
    private static function prepareTurnoverData($data): array
    {
        $brands = array_column(self::$brands, 'name', 'id');

        $csvData[] = array_merge(['Date \ Brand'], $brands); //header row

        //data rows
        foreach ($data as $row) {
            $csvData[] = $row;
        }

        $csvData[] = self::getBrandTotals($data); //last row with brandTotals turnovers
        $csvData[] = self::getBrandTotals($data, true); //last row with brandTotals without Vat

        return $csvData;
    }

    /**
     * @param array $data
     * @param bool $removeVat
     * @return string[]
     */
    private static function getBrandTotals(array $data, bool $removeVat = false): array
    {
        $brandTotals = ($removeVat) ? ['VAT Excluded'] : ['VAT Included'];

        foreach ($data as $row) {
            foreach ($row as $key => $value) {

                $value =
                    ($removeVat && is_numeric($value)) ?
                        Util::removeVat($value, GmvRepository::VAT) :
                        $value;

                if ($key != 'date') {
                    if (isset($brandTotals[$key])) {
                        $brandTotals[$key] += $value;
                    } else {
                        $brandTotals[$key] = $value;
                    }
                }
            }
        }

        return $brandTotals;
    }

}