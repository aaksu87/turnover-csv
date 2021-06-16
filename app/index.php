<?php

require 'vendor/autoload.php';
require 'config.php';

use App\Service\ReportService;
use App\Service\CsvService;
use App\Repository\BrandRepository;
use App\Repository\GmvRepository;

$startDate = '2018-05-01 00:00:00';
$endDate = '2018-05-07 00:00:00';

try {
    $reportService = (new ReportService((new BrandRepository()), (new GmvRepository()), (new CsvService())));
    $reportService->exportTurnoverCsv($startDate, $endDate);
} catch (Exception $e) {
    echo 'Something is wrong: ' . $e->getMessage();
}

