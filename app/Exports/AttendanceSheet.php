<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $rows = [];

        $rows[] = [

            'Name',
            'Class',
            'Table',
            'Status',
            'Check In Time'

        ];

        $guests = DB::table('guests')
            ->orderBy('class_code')
            ->orderBy('nama')
            ->get();

        foreach($guests as $guest)
        {
            $rows[] = [

                $guest->nama,
                $guest->class_code,
                $guest->table_no,
                $guest->checkin_status,
                $guest->checkin_time

            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Attendance';
    }
}