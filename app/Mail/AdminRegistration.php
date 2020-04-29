<?php

namespace App\Mail;

use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data, $setting,$user;
    public function __construct($data, $setting, $user)
    {
        $this->data = $data;
        $this->setting = $setting;
        $this->user =$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->setting['value'],$this->setting['value'])->subject('User Registration')->view('emails.registeradmin')->withData($this->data)->withUser($this->user);

    }
}
