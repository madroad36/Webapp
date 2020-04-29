<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropetyAssignBroker extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $broker;
    protected $property;
    protected $companyname;
    protected $companyemail;


    public function __construct( $property,$broker,$companyname,$companyemail)
    {
        $this->property = $property;
        $this->broker = $broker;
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

        return $this->from($this->companyemail['value'],$this->companyname['value'])->subject('Assign Broker')->view('emails.assignBroker')->withProperty($this->property)->withBroker($this->broker);

    }
}
