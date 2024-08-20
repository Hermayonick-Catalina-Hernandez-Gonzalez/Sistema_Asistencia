<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CredencialesAlumnoCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public $pin;

    public function __construct($email, $password, $pin)
    {
        $this->email = $email;
        $this->password = $password;
        $this->pin = $pin;
    }

    public function build()
    {
        return $this->view('emails.credenciales_alumno');
    }
}
