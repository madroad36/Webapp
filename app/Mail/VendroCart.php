<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendroCart extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $request,$companyemail ,$companyname,$user,$owner;
    public function __construct($request,$companyemail ,$companyname,$user,$owner)
    {
        $this->request = $request;
        $this->companyname = $companyname;
        $this->companyemail = $companyemail;
        $this->owner =$owner;
        $this->user = $user;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->companyemail['value'],$this->companyname['value'])->subject('New Product Order')->view('emails.vendorcart')->withRequest($this->request)->withUser($this->user)->withOwner($this->owner);
    }
}
