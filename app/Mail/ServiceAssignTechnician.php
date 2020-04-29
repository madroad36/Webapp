<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ServiceAssignTechnician extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $service,$technician,$companyname,$companyemail;
    public function __construct($service,$technician,$companyname,$companyemail)
    {
        $this->service = $service;
        $this->technician = $technician;
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
        return $this->from($this->companyemail['value'],$this->companyname['value'])->subject('Assign Technician')->view('emails.assignTechnician')->withService($this->service)->withTechnician($this->technician);
    }
}
