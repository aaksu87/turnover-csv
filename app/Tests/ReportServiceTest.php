<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\ReportService;
use App\Repository\BrandRepository;
use App\Repository\GmvRepository;
use App\Service\CsvService;

final class ReportServiceTest extends TestCase
{
    private ReportService $reportService;
    private CsvService $csvServiceMock;
    private BrandRepository $brandRepositoryMock;
    private GmvRepository $gmvRepositoryMock;

    protected function setUp(): void
    {
        $this->brandRepositoryMock = \Mockery::mock('App\Repository\BrandRepository');
        $this->gmvRepositoryMock = \Mockery::mock('App\Repository\GmvRepository');
        $this->csvServiceMock = \Mockery::mock('App\Service\CsvService');
        parent::setUp();
    }

    public function testInvalidDatesReturnsException(): void
    {
        $startDate = 'invalid';
        $endDate = 'date';

        $this->brandRepositoryMock->shouldReceive('getAllBrands')->once()->andReturn([["id"=>1,"name"=>"O-Brand"],["id"=>2,"name"=>"T-Brand"]]);
        $this->gmvRepositoryMock->shouldReceive('getTurnoverData')->once()->andReturn([]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No record found');

        $this->reportService = new ReportService($this->brandRepositoryMock, $this->gmvRepositoryMock, (new CsvService()));
        $this->reportService->exportTurnoverCsv($startDate,$endDate);
    }

    public function testDatesWithoutDataReturnsException(): void
    {
        $startDate = '2011-03-01 00:00:00';
        $endDate = '2011-03-05 00:00:00';

        $this->brandRepositoryMock->shouldReceive('getAllBrands')->once()->andReturn([["id"=>1,"name"=>"O-Brand"],["id"=>2,"name"=>"T-Brand"]]);
        $this->gmvRepositoryMock->shouldReceive('getTurnoverData')->once()->andReturn([]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No record found');

        $this->reportService = new ReportService($this->brandRepositoryMock, $this->gmvRepositoryMock, (new CsvService()));
        $this->reportService->exportTurnoverCsv($startDate,$endDate);
    }

    public function testSuccessResultCallCsvService(): void
    {
        $startDate = '2018-03-01 00:00:00';
        $endDate = '2018-03-07 00:00:00';

        $this->brandRepositoryMock->shouldReceive('getAllBrands')->once()->andReturn([["id"=>1,"name"=>"O-Brand"],["id"=>2,"name"=>"T-Brand"]]);
        $this->gmvRepositoryMock->shouldReceive('getTurnoverData')->once()->andReturn([["date"=>"01-03-2018","O-Brand"=> 3985.45]]);

        $this->csvServiceMock->shouldReceive('setFileName')->once()->andReturn($this->csvServiceMock);
        $this->csvServiceMock->shouldReceive('exportCsv')->once()->andReturn('Turnover_2018-03-01_2018-03-07.csv');

        $this->reportService = new ReportService($this->brandRepositoryMock, $this->gmvRepositoryMock, $this->csvServiceMock);
        $filename = $this->reportService->exportTurnoverCsv($startDate,$endDate);

        $this->assertEquals('Turnover_2018-03-01_2018-03-07.csv',$filename);

    }
}
