<?php

namespace App\Http\Controllers\Auth;

use DB;
use Mail;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\Model;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        return Validator::make($data, [
            'voornaam' => 'required|min:2',
            'achternaam' => 'required|min:2',
            'organisatienaam' => 'required|min:2',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'functie' => 'required|min:5',
            'type' => 'required',
            'telefoon' => 'required|numeric|min:10',
            'postcode' => 'required|min:6|max:6',
            'huisnummer' => 'required|numeric',
            'adres' => 'required',
            'woonplaats' => 'required',
            'website' => array('required', 'regex:'.$regex),
            'reden' => 'required|min:100',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'voornaam' => $data['voornaam'],
            'tussenvoegsel' => $data['tussenvoegsel'],
            'achternaam' => $data['achternaam'],
            'geslacht' => $data['geslacht'],
            'organisatienaam' => $data['organisatienaam'],
            'functie' => $data['functie'],
            'email' => $data['email'],
            'website' => $data['website'],
            'telefoon' => $data['telefoon'],
            'type' => $data['type'],
            'postcode' => $data['postcode'],
            'huisnummer' => $data['huisnummer'],
            'huisnummertoevoeging' => $data['huisnummertoevoeging'],
            'adres' => $data['adres'],
            'woonplaats' => $data['woonplaats'],
            'password' => bcrypt($data['password']),
            'email_token' => str_random(10),
            'reden' => $data['reden'],
            'nieuwsbrief' => $data['nieuwsbrief'],
        ]);
    }


    public function verify($token)
    {

        /*
        *   Deze actie triggert de verified-methode in de User-model (App\User.php)
        */

            auth()->logout();
            try {
                User::where('email_token',$token)->firstOrFail()->verified();
            } catch (Exception $e) {
                return redirect('login')->with('message', 'Uw emailverificatie is al voltooid. U kunt nu inloggen.');  
            }
            
            return redirect('login')->with('message', 'Bedankt! U heeft zojuist uw email geverifieerd. Als uw account nog niet was goedgekeurd kunt pas inloggen als de Sinterklaasbank uw aanmelding heeft goedgekeurd. Als u een bestaande gebruiker was en uw emailadres heeft gewijzigd, kunt u meteen inloggen.');       

    }

    public function register(Request $request)
    {
        
        // Laravel validation
        $validator = $this->validator($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }
        // Using database transactions is useful here because stuff happening is actually a transaction
        // I don't know what I said in the last line! Weird!
        DB::beginTransaction();
        try
        {
            $user = $this->create($request->all());
            // After creating the user send an email with the random token generated in the create method above
            $email = new EmailVerification(new User(['email_token' => $user->email_token, 'voornaam'=>ucfirst($user->voornaam)]));
            Mail::to($user->email)->send($email);
            DB::commit();
            auth()->logout();
            return redirect('login')->with('message', 'Er is zojuist een email gestuurd om uw emailadres te verifieren. Nadat u op de link in de email heeft geklikt kan de Sinterklaasbank uw inschrijving beoordelen. Daarna kunt u inloggen. Heeft u de mail niet gehad? Controleer dan uw spam-mappen in uw email!');
        }
        catch(Exception $e)
        {
            DB::rollback(); 
            return redirect('login')->with('message', 'Er ging iets fout. Mogelijk heeft u de activatie-link al gebruikt.');    
        }
    }
}
