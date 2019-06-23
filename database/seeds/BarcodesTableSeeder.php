<?php

use Illuminate\Database\Seeder;

class BarcodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barcodes')->insert([

        [//1
            'barcode' => 'SINTB-W6ONR1',
            'kid_id' => null, 
            'user_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//2
            'barcode' => 'SINTB-N1ULRN',
            'kid_id' => null, 
            'user_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//3
            'barcode' => 'SINTB-AIBN24',
            'kid_id' => null,     
            'user_id' => null, 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//4
            'barcode' => 'SINTB-AIQT28',
            'kid_id' => null,     
            'user_id' => null, 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//5
            'barcode' => 'SINTB-AIQG22',
            'kid_id' => null,    
            'user_id' => null,  
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],

        ]);
    }
}
              