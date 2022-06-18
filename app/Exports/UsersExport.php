<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    private string $firstDate;
    private string $endDate;

    public function __construct(string $firstDate, string $endDate)
    {
        $this->firstDate = $firstDate;
        $this->endDate = $endDate;
    }


    public function collection()
    {
        return User::select('id', 'name', 'email', 'birth_date')
            ->whereBetween('birth_date', [$this->firstDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Birth Date'];
    }
}
