<?php

namespace App\Contracts;

use App\Service\CsvService;

interface CsvServiceInterface
{
    /**
     * @param string $name
     * @return \App\Service\CsvService
     */
    public function setFileName(string $name): CsvService;

    /**
     * @return string
     */
    public function getFileName(): string;

    /**
     * @param array $data
     * @return string
     */
    public function exportCsv(array $data) : string;

}