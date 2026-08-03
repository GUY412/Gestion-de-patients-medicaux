<?php

namespace App\Mail;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FichePatientMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Patient $patient, public string $pdfContent) {}

    public function build()
    {
        return $this->subject('Fiche patient — ' . $this->patient->nom . ' ' . $this->patient->prenom)
            ->view('emails.fiche-patient')
            ->attachData($this->pdfContent, 'fiche-patient.pdf', ['mime' => 'application/pdf']);
    }
}