<?php

namespace App\Exports;

use App\User;
use App\Family;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IntermediairsExport implements FromCollection, WithHeadings
{
    public function collection()
    {


    	$users = DB::table('users')
            ->join('familys', 'users.id', '=', 'familys.user_id')
            ->where('familys.goedgekeurd', '=', 1)
            ->select('users.voornaam', 'users.achternaam', 'users.email', 'users.organisatienaam')
            ->get();

        $unique = $collection->unique('users');

        return $unique;

        //return User::all();
    }

    public function headings(): array
    {
        return [
            'Voornaam',
            'Achternaam',
            'Email',
            'Organisatie',
        ];
    }

}
