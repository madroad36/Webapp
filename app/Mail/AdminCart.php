<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCart extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $request,$companyname,$companyemail,$user;
    public function __construct($request,$companyname,$companyemail,$user)
    {
        $this->request = $request;
        $this->companyname = $companyname;
        $this->companyemail =$companyemail;
        $this->user = $user;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->companyemail['value'],$this->companyname['value'])->subject('New Product Order')->view('emails.admincart')->withRequest($this->request)->withUser($this->user);
    }
}
