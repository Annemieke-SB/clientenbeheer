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
            'barcode' => '6299930034000122339',
            'kid_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//2
            'barcode' => '6299930034000122347',
            'kid_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//3
            'barcode' => '6299930034000122362',
            'kid_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//4
            'barcode' => '6299930034000122370',
            'kid_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//5
            'barcode' => '6299930034000122388',
            'kid_id' => null,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],

        ]);
    }
}
              