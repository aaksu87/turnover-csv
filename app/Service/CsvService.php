<?php

namespace App\Service;

use App\Contracts\CsvServiceInterface;

class CsvService implements CsvServiceInterface
{
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @param string $name
     * @return $this
     */
    public function setFileName(string $name): CsvService
    {
        $this->fileName = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param array $data
     * @return string
     */
    public function exportCsv(array $data) : string
    {
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $this->getfileName());
        foreach ($data as $rows) {
            fputcsv($fp, $rows);
        }

        return $this->getFileName();
    }

}