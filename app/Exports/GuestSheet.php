<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GuestSheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize
{
    public function array(): array
    {
        $rows = [];

        $rows[] = [

            'Class',
            'Table',
            'Name',
            'Company',
            'Phone'

        ];

        $guests = DB::table('guests')
            ->orderBy('class_code')
            ->orderBy('nama')
            ->get();

        foreach($guests as $guest)
        {
            $rows[] = [

                $guest->class_code,
                $guest->table_no,
                $guest->nama,
                $guest->company,
                $guest->phone_no

            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Guest Listing';
    }
}