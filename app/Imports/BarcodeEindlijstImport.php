<?php

namespace App\Imports;

use App\Barcode;
use Config;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarcodeEindlijstImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            
                $barcodestring = $row["code"];

                ini_set('max_execution_time', 3600);

                $barcode = Barcode::where('barcode', $barcodestring)->update([
                    'value_of_redemptions' => $row['value'],
                    'date_redemption' => $row['date']
                ]);  
        }
    }
}
