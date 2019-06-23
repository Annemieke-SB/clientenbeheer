<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminNewUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user = User::find($id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nieuwe gebruiker in cliëntenbeheer')
                    ->view('emails.notify_admin_new_user')
                    ->with([
                        'voornaam' => $this->user->voornaam,
                        'tussenvoegsel' => $this->user->tussenvoegsel,
                        'achternaam' => $this->user->achternaam,
                        'email' => $this->user->email,
                        'organisatienaam' => $this->user->organisatienaam
                    ]);
    }
}
