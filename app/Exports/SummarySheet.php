<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummarySheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $rows = [];

        $rows[] = [
            'Class',
            'Table',
            'Capacity',
            'Used',
            'Available'
        ];

        $classes = DB::table('classes')
            ->orderBy('id')
            ->get();

        foreach($classes as $class)
        {
            $used = DB::table('guests')
                ->where(
                    'class_code',
                    $class->class_code
                )
                ->count();

            $rows[] = [

                $class->class_code,
                $class->table_no,
                $class->max_pax,
                $used,
                $class->max_pax - $used

            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Summary';
    }
}