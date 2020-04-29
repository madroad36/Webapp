<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropertyBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $booking;
    protected $property;
    protected $companyname;
    protected $companyemail;


    public function __construct( $property,$booking,$companyemail,$companyname)
    {

        $this->property = $property;
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

        return $this->from($this->companyemail['value'],$this->companyname['value'])->subject('Property Booking')->view('emails.propertyBook')->withProperty($this->property)->withBooking($this->booking);

    }
}
