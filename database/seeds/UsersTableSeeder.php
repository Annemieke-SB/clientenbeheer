<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

        [//1
            'organisatienaam' => 'Sinterklaasbank',
            'voornaam' => 'Henrique',
            'tussenvoegsel' => 'van',
            'achternaam' => 'Huisstede',
            'email' => 'henrique@van.huisste.de',  
            'geslacht' => 'm',  
            'functie' => 'Webmaster',         
            'password' => Hash::make('pipo9889'),
            'emailverified' => 1,
            'reden' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,',
            'website' => 'http://van.huisste.de',
            'telefoon' => '0643851281',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//2
            'organisatienaam' => 'Voetbalvereniging VJKJKSJ',
            'voornaam' => 'Annette',
            'tussenvoegsel' => '',
            'achternaam' => 'schipper',
            'email' => 'm.kolder1@van.huisste.de',
            'geslacht' => 'v',   
            'functie' => 'Hulpverlener', 
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex',
            'website' => 'http://schippatje.com',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//3
            'organisatienaam' => 'Stichting De Geldmachine',
            'voornaam' => 'Sandra',
            'tussenvoegsel' => '',
            'achternaam' => 'Nagel',
            'email' => 's.nagel@van.huisste.de',
            'geslacht' => 'v',  
            'functie' => 'Hulpverlener', 
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally',
            'website' => 'http://www.nagel.ck',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//4
            'organisatienaam' => 'Vriend in barre tijden',
            'voornaam' => 'Test',
            'tussenvoegsel' => '',
            'achternaam' => 'intermediair',
            'email' => 'intermediair@sinterklaasbank.nl',
            'geslacht' => 'v',
            'functie' => 'Hulpverlener',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles. Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues. Li nov lingua franca va esser plu simplic e regulari quam li existent Europan',
            'website' => 'http://de.tester.online',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//5
            'organisatienaam' => 'Sinterklaasbank',
            'voornaam' => 'Elisa',
            'achternaam' => 'Nuij',
            'tussenvoegsel' => '',
            'email' => 'elisa@sinterklaasbank.nl',
            'geslacht' => 'v',
            'functie' => 'Voorzitter',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => '',
            'website' => 'http://elisa.com',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [//6
            'organisatienaam' => 'De Oplossing',
            'voornaam' => 'Test',
            'tussenvoegsel' => '',
            'achternaam' => 'Raadpleger',
            'email' => 'raadpleger@sinterklaasbank.nl',
            'geslacht' => 'v',
            'functie' => 'Hulpverlener',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more',
            'website' => 'http://test.org',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 2,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),            
        ],
        [//7
            'organisatienaam' => 'Schuldhulpverlening Het Hoekje',
            'voornaam' => 'Intermed',
            'tussenvoegsel' => '',
            'achternaam' => 'z instell',
            'email' => 'intzin@sinterklaasbank.nl',
            'geslacht' => 'v',
            'functie' => 'Hulpverlener',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to',
            'website' => 'http://www.bookk.com',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),            
        ],
        [//8
            'organisatienaam' => 'Blabla Hulpverleners',
            'voornaam' => 'Intermed m',
            'tussenvoegsel' => '',
            'achternaam' => 'instell z fam',
            'email' => 'intminzfam@sinterklaasbank.nl',
            'geslacht' => 'v',
            'functie' => 'Hulpverlener',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. "Whats happened to me?" he thought. It wasnt a dream. His room, a proper human',
            'website' => 'http://bla.nl',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),            
        ],
        [//8
            'organisatienaam' => 'Sinterklaasbank',
            'voornaam' => 'Annemieke',
            'tussenvoegsel' => 'van den',
            'achternaam' => 'Heijden',
            'email' => 'annemieke@sinterklaasbank.nl',
            'functie' => 'Coordinator',
            'geslacht' => 'v',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now. When, while the lovely valley teems with',
            'website' => 'http://annemieke.nl',
            'telefoon' => '0612345678',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),            
        ],
        [//8
            'organisatienaam' => 'Sinterklaasbank',
            'voornaam' => 'Harm',
            'tussenvoegsel' => '',
            'achternaam' => 'Super',
            'email' => 'harm.super@sinterklaasbank.nl',
            'functie' => 'Clientenbeheer',
            'geslacht' => 'm',
            'password' => Hash::make('tester'),
            'emailverified' => 1,
            'reden' => 'The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps. Bawds jog, flick quartz, vex nymphs. Waltz, bad nymph, for quick jigs vex! Fox nymphs grab quick-jived waltz. Brick quiz whangs jumpy veldt fox. Bright vixens jump; dozy fowl quack. Quick wafting zephyrs vex bold Jim. Quick zephyrs blow, vexing daft Jim. Sex-charged fop blew my junk TV quiz. How quickly daft jumping zebras vex. Two driven jocks help fax my big quiz. Quick, Baz, get my woven flax jodhpurs! "Now fax quiz Jack!" my brave',
            'website' => '',
            'telefoon' => '0646109392',
            'intermediairtype_id' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'activated' => 1,
            'usertype' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),            
        ]




		]);

				$users = factory(App\User::class, 500)->create();

    }
}
              
