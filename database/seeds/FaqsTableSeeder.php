<?php

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqs')->insert([[
            'vraag' => 'Mijn postcode wordt niet geaccepteerd, en nu?',
            'antwoord' => 'Wij gebruiken de postcode-tabellen van Postcode.nl en kunnen daar verder niets aan veranderen. In een enkele keer kan het zijn dat een postcode niet in de tabel staat. Let goed op de huisnummering! Mocht het alsnog niet lukken, zoek dan naar een mogelijkheid om uit te wijken. U mag ook een postbus opgeven.',
            'category' => 1,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'vraag' => 'Hoe lang blijven de ingevoerde gegevens bewaard?',
            'antwoord' => 'De Sinterklaasbank werk elk jaar weer met een schone database. Alle gegevens zijn op 31 december weer verwijderd. Op die manier springen wij het meest efficient met uw gegevens om. Het nadeel is wel dat u elk jaar weer opnieuw moet inschrijven. De gegevens zullen niet aan derden worden verhandeld of overgedragen, anders dan noodzakelijk is voor het afhandelen en verstrekken van de kadobonnen.',
            'category' => 2,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'vraag' => 'Waarom kan ik nog geen kadobonnen downloaden?',
            'antwoord' => 'Wij willen de ingevoerde gegevens goed controleren en beoordelen. Pas als alle gegevens binnenzijn en de sluitingsdatum is gepasseerd, kunnen we dat doen. Enkele dagen daarna zal uw downloadpagina worden geopend. U krijgt daarover automatisch een email.',
            'category' => 3,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]]);
    }
}
