<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        return Transaction::all();
    }

    public function headings(): array
    {
        return ['ID', 'Date In', 'Date Out'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->date_in,
            $transaction->date_out,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD2,//NumberFormat::FORMAT_NUMBER_00,
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
    }
}