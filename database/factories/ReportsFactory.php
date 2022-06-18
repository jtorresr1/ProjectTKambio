<?php

namespace Database\Factories;

use App\Models\Reports;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ReportsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Reports::class;

    public function definition()
    {
        return [
            'title' => $this->faker->text(),
            'file' => 'Users_2022-06-15 22:59:26.xlsx',
            'report_link' => $this->faker->url(),
        ];
    }
}
