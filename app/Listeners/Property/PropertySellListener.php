<?php

namespace App\Listeners\Property;


use App\Events\Property\PropertyBooking;
use App\Events\Property\PropertyCreated;
use App\Events\Property\PropertySell;
use App\Models\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropertySellListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function onsell($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.booking.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-check-circle"></i>'
        ]);
    }
    public function onBooking($event){

        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.booking.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-check-circle"></i>'
        ]);
    }
    public function onCreated($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.property.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);
    }

    public function subscribe($event){


        $event->listen(
            PropertySell::class,
            'App\Listeners\Property\PropertySellListener@onsell'

        );
        $event->listen(
            PropertyBooking::class,
            'App\Listeners\Property\PropertySellListener@onBooking'


        );
        $event->listen(
            PropertyCreated::class,
            'App\Listeners\Property\PropertySellListener@onCreated'


        );

    }
}
