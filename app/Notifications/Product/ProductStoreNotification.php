<?php

namespace App\Notifications\Product;

use App\Repositories\NotificationRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductStoreNotification extends Notification
{
    use Queueable;
    private $product, $user, $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product, $user)
    {
        $this->product = $product;
        $this->user = $user;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toArray(){
        $data = [
            'type' => 'Add-Product',
            'product_id'=>$this->product->id,
            'receiver_id'=>$this->user,

        ];

        return \App\Models\Notification::create($data);
    }

}
