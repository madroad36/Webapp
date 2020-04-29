<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropertySelling extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $message;
    protected $booking;
    protected $property;
    protected $companyname;
    protected $companyemail;


    public function __construct( $property,$booking,$message,$companyemail,$companyname)
    {

       $this->property = $property;
       $this->message = $message;
        $this->companyemail =$companyemail;
        $this->companyname = $companyname;
        $this->booking = $booking;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->companyemail['value'],$this->companyname['value'])->subject($this->message)->view('emails.propertySell')->withProperty($this->property)->withNotification($this->message)->withBooking($this->booking);

    }
}
