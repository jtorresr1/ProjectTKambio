<?php

namespace App\Exports;

use App\Models\User;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    private $firstDate;
    private $endDate;

    public function __construct(string $firstDate, string $endDate)
    {
        $this->firstDate = $firstDate;
        $this->endDate = $endDate;
    }


    public function collection()
    {
        return User::select("id", "name", "email", "birth_date")
            ->whereBetween('birth_date',[$this->firstDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return ["ID", "Name", "Email", "Birth Date"];
    }
}
