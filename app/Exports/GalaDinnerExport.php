<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GalaDinnerExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [

            new SummarySheet(),
            new GuestSheet(),
            new AttendanceSheet()

        ];
    }
}