<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestFinishedSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $Test;
    public $Projet;
    public $Date;
    public $FileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($test, $projet, $filename)
    {
        $this->Test = $test;
        $this->Projet = $projet;
        $this->FileName = $filename;
        $this->Date = date('d/m/Y');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('emails.email')
                  ->attach(public_path() . "/storage/logProject/".$this->FileName.".txt");
    }
}
