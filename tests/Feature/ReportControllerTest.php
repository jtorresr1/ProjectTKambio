<?php

namespace Tests\Feature;

use App\Models\Reports;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Mockery\MockInterface;
use Spatie\FlareClient\Context\ContextProvider;
use Spatie\FlareClient\Report;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsAllReports()
    {

        #Act
        $response = $this->getJson('/api/list-reports');

        #Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'reports' => [
                    'data',
                    'current_page'
                ]
            ]);
    }

    public function testCacheWhenReturnAllReports()
    {
        Cache::shouldReceive('has')->andReturn(true);
        Cache::shouldReceive('get')->andReturn(self::any(Report::class));

        $response = $this->getJson('/api/list-reports');

        #Assert
        $response->assertStatus(200);
    }


    public function testWhenExistsManyPagesAndReturnAllReports()
    {

        $response = $this->getJson('/api/list-reports?page=2');

        #Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['reports' => ['from' => null]])
            ->assertJsonStructure([
                'reports' => [
                    'links',
                    'current_page',
                    'data'
                ]
            ]);
    }

    public function testWhenStoreReports()
    {
        $body = [
            'description' => 'Test Title',
            'startDate' => '1980-01-01',
            'endDate' => '1990-01-01'
        ];

        $response = $this->postJson('/api/generate-report', $body);

        #Assert
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['report' => ['title' => 'Test Title']])
            ->assertJsonStructure([
                'report' => [
                    'title',
                    'file',
                    'updated_at',
                    'created_at',
                    'id',
                    'report_link'
                ]
            ]);
    }


    public function testWhenShowSpecificReport()
    {

        Reports::factory()->create()->save();

        $response = $this->getJson(route('reports.show', 1));

        #Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'report' => [
                    'title',
                    'file',
                    'updated_at',
                    'created_at',
                    'id',
                    'report_link'
                ]
            ]);
    }

    public function testWhenShowSpecificReportDoesntExist()
    {

        $response = $this->getJson(route('reports.show', 1));

        #Assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }


    public function testWhenDownloadSpecificReport()
    {
        Reports::factory()->create()->save();

        $response = $this->get(route('reports.download', 1));

        #Assert
        $response->assertDownload();
    }
}
