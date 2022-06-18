<?php

namespace App\Services;

use App\Jobs\StoreExcel;

class GeneratorExcel
{
    public function generate(string $startDate, string $endDate): string
    {
        $fileName = 'Users_' . date('Y-m-d H:i:s') . '.xlsx';
        StoreExcel::dispatch($startDate, $endDate, $fileName);
        return $fileName;
    }
}
