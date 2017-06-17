<?php

use Illuminate\Database\Seeder;

class FamilysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('familys')->insert([[
            'achternaam' => 'vd Putten',
            'adres' => 'Schepenweg',
            'huisnummer' => 14,
            'huisnummertoevoeging' => '',
            'postcode' => '3211XS',
            'woonplaats' => 'Geervliet',
            'telefoon' => '0683292868',
            'andere_alternatieven' => 0,
            'motivering' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'irishabsvdlaan@gmddail.com',
            'intermediair_id' => 1,
            'bezoek_sintpiet' => 0,      
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),        
        ],
        [
            'achternaam' => 'Grabijn',
            'adres' => 'de Krimpen',
            'huisnummer' => 29,
            'huisnummertoevoeging' => '',
            'postcode' => '9621CC',
            'woonplaats' => 'Slochteren',
            'telefoon' => '0641160276',
            'andere_alternatieven' => 1,
            'motivering' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'susanne.xx.-@hotddmail.com',
            'intermediair_id' => 2,
            'bezoek_sintpiet' => 0,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
        ],
        [
            'achternaam' => 'Bladibla',
            'adres' => 'Hoofdstraat',
            'huisnummer' => 9,
            'huisnummertoevoeging' => 'a',
            'postcode' => '9620GC',
            'woonplaats' => 'Amsterdam',
            'telefoon' => '0612345678',
            'andere_alternatieven' => 0,
            'motivering' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'glop@testmdail.com',
            'intermediair_id' => 2,
            'bezoek_sintpiet' => 0,    
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
        ],
        [
            'achternaam' => 'de Vries',
            'adres' => 'Dorpstraat',
            'huisnummer' => 124,
            'huisnummertoevoeging' => '3 hoog',
            'postcode' => '1993AV',
            'woonplaats' => 'Kortenhoef',
            'telefoon' => '0698765434',
            'andere_alternatieven' => 0,
            'motivering' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'pop@hotmfail.com',
            'intermediair_id' => 2,
            'bezoek_sintpiet' => 0,      
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
        ],        
        [
            'achternaam' => 'Basou',
            'adres' => 'Vettumse Kleffen',
            'huisnummer' => 123,
            'huisnummertoevoeging' => '',
            'postcode' => '5801SE',
            'woonplaats' => 'Venray',
            'telefoon' => '0685411071',
            'andere_alternatieven' => 0,
            'motivering' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'mohamedbasou121@gmddail.com',
            'intermediair_id' => 3,
            'bezoek_sintpiet' => 0,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),        
        ],
        [
            'achternaam' => 'vd Putten',
            'adres' => 'Deken Berdenstraat',
            'huisnummer' => 3,
            'huisnummertoevoeging' => '',
            'postcode' => '5801ET',
            'woonplaats' => 'Venray',
            'telefoon' => '0623661147',
            'andere_alternatieven' => 0,
            'motivering' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'gewoonsuus@ddlive.nl',
            'intermediair_id' => 3,
            'bezoek_sintpiet' => 0,      
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),        
        ]]
        );
    }
}
