<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailActivationtoggle extends Mailable
{
    use Queueable, SerializesModels;

    public $mailvars;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mailvars $mailvars)
    {
        $this->mailvars = $mailvars;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Bericht van de Sinterklaasbank: uw accountstatus is gewijzigd')
                    ->view('emails.activationtoggle')
                    ->with([
                        'voornaam' => $this->user->voornaam,
                        'tussenvoegsel' => $this->user->tussenvoegsel,
                        'achternaam' => $this->user->achternaam,
                        'email' => $this->user->email,
                        'organisatienaam' => $this->user->organisatienaam
                    ]);
    

        return $this->subject('Bericht van de Sinterklaasbank – uw accountstatus is gewijzigd')
                    ->view('emails.activationtoggle');
    }
}
