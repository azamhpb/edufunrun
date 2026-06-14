<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummarySheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize,
    WithStyles
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
    public function styles(Worksheet $sheet)
{
    // Header

    $sheet->getStyle('A1:E1')
    ->getFill()
    ->setFillType(
        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
    )
    ->getStartColor()
    ->setRGB('212529');

    $sheet->getStyle('A1:E1')
        ->getFont()
        ->setBold(true)
        ->getColor()
        ->setRGB('FFFFFF');

    $sheet->freezePane('A2');

    foreach(
        range(
            2,
            $sheet->getHighestRow()
        ) as $row
    )
    {
        $classCode =
        $sheet->getCell(
            'A'.$row
        )->getValue();

        if(
            str_starts_with(
                $classCode,
                'DIAMOND'
            )
        )
        {
            $sheet->getStyle(
                'A'.$row.':E'.$row
            )
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('E7AA51');
        }

        elseif(
            str_starts_with(
                $classCode,
                'PLATINUM'
            )
        )
        {
            $sheet->getStyle(
                'A'.$row.':E'.$row
            )
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('B9B9B9');
        }

        elseif(
            str_starts_with(
                $classCode,
                'GOLD'
            )
        )
        {
            $sheet->getStyle(
                'A'.$row.':E'.$row
            )
            ->getFill()
            ->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB('AC8E68');

            $sheet->getStyle(
                'A'.$row.':E'.$row
            )
            ->getFont()
            ->getColor()
            ->setRGB('FFFFFF');
        }

        elseif(
            str_starts_with(
                $classCode,
                'SILVER'
            )
        )
        {
            $sheet->getStyle(
                'A'.$row.':E'.$row
            )
            ->getFill()
            ->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setRGB('43D1FF');

            $sheet->getStyle(
                'A'.$row.':E'.$row
            )
            ->getFont()
            ->getColor()
            ->setRGB('FFFFFF');
        }
    }

    return [];
}
}