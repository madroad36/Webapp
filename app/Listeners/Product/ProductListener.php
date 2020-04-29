<?php

namespace App\Listeners\Product;

use App\Events\Product\ProductCreated;
use App\Events\Product\ProductSell;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */


    public function onCreated($event){
        Notification::create([
            'receiver_id'=>$event->object->receiver_id,
            'link'=>route('admin.product.index'),
            'message'=>'New Product has been added',
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);
    }
    public function onSell($event){
        
        Notification::create([
            'receiver_id'=>$event->object['receiver_id'],
            'link'=>route('admin.product.order'),
            'message'=>$event->object['message'],
            'icon'=> '<i class="fa fa-plus"></i>'
        ]);
    }

    public function subscribe($event){

        $event->listen(
            ProductCreated::class,
            'App\Listeners\Product\ProductListener@onCreated'

        );
        $event->listen(
            ProductSell::class,
            'App\Listeners\Product\ProductListener@onSell'

        );

    }
}
