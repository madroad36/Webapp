<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminProperty extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $request,$companyname,$companyemail;
    public function __construct($request,$companyname,$companyemail)
    {


        $this->request = $request;
        $this->companyname = $companyname;
        $this->companyemail =$companyemail;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->companyemail,$this->companyname)->subject('New Property is added')->view('emails.adminProperty')->withRequest($this->request);
    }
}
