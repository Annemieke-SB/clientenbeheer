<?php

namespace App\Exports;

use App\User;
use App\Kid;
use App\Family;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KidsExport implements FromCollection, WithHeadings
{
    public function collection()
    {


    	$kids = DB::table('kids')
            ->join('users', 'users.id', '=', 'kids.user_id')
            ->join('familys', 'familys.id', '=', 'kids.family_id')
            ->select('kids.voornaam', 'familys.achternaam', 'users.email', 'users.organisatienaam')
            ->where('familys.goedgekeurd', '=', 1)
            ->get();


        return $kids;

        //return User::all();
    }

    public function headings(): array
    {
        return [
            'Voornaam kind',
            'Achternaam gezin',
            'Intermediair email',
            'Intermediair organisatie',
        ];
    }

}
