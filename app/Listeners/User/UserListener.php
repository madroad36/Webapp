<?php

namespace App\Listeners\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\User\UserRegistration;
use App\Events\User\UserBroker;
use App\Events\User\UserTechnician;
use App\Events\User\UserVendor;
use App\Models\Notification;

class UserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
   
    public function onRegister($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.users.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);

    }
    public function onBroker($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.broker.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);

    }
    public function onTechnician($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.technician.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);

    }
    public function onVendor($event){
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.vendor.index'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);

    }
    public function subscribe($event){



        $event->listen(
            UserRegistration::class,
            'App\Listeners\User\UserListener@onRegister'

        );
        $event->listen(
            UserBroker::class,
            'App\Listeners\User\UserListener@onBroker'

        );
        $event->listen(
            UserTechnician::class,
            'App\Listeners\User\UserListener@onTechnician'

        );
        $event->listen(
            UserVendor::class,
            'App\Listeners\User\UserListener@onVendor'

        );
        
    }
}
