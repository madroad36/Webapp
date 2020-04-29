<?php

namespace App\Listeners\Service;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Service\ServiceOrder;
use App\Events\Service\ServiceFinished;
use App\Models\Notification;

class ServiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function onOrder($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.servicerequest.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);

    }
    public function onfinished($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.servicerequest.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);

    }
    public function subscribe($event){


        $event->listen(
            ServiceOrder::class,
            'App\Listeners\Service\ServiceListener@onOrder'

        );
        $event->listen(
            ServiceFinished::class,
            'App\Listeners\Service\ServiceListener@onfinished'

        );
        
    }
}
