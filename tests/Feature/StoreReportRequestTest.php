<?php

namespace Tests\Feature;

use App\Http\Requests\StoreReportRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use Tests\TestCase;

class StoreReportRequestTest extends TestCase
{
    public function testNoDescriptionInStoreReport()
    {
        $body = [
            'startDate' => '1980-01-01',
            'endDate' => '1990-01-01'
        ];

        $response = $this->postJson('/api/generate-report', $body);

        #Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['message' => 'The description field is required.'])
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    public function testStartDateErrorInStoreReport()
    {
        $body = [
            'description' => 'Texto',
            'startDate' => '1979-01-01',
            'endDate' => '1990-01-01'
        ];

        $response = $this->postJson('/api/generate-report', $body);

        #Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['message' => 'The start date must be a date after or equal to 1980-01-01.'])
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    public function testEndDateBeforeStartDateErrorInStoreReport()
    {
        $body = [
            'description' => 'Texto',
            'startDate' => '1990-01-01',
            'endDate' => '1980-01-01'
        ];

        $response = $this->postJson('/api/generate-report', $body);

        #Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['message' => 'The end date must be a date after start date.'])
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    public function testEndDateErrorInStoreReport()
    {
        $body = [
            'description' => 'Texto',
            'startDate' => '1990-01-01',
            'endDate' => '2011-01-01'
        ];

        $response = $this->postJson('/api/generate-report', $body);

        #Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['message' => 'The end date must be a date before or equal to 2010-12-31.'])
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}
