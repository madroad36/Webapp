<?php

namespace App\Http\ViewComposers\Backend;


use App\Repositories\NotificationRepository;
use Illuminate\View\View;
use Auth;


class NotificationComposer
{
    /**
     * Create a new sidebar composer.
     *
     * @return void
     */
    protected $notification;

    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {


        $notifications = $this->notification->orderBy('created_at','desc')->where('receiver_id',Auth::user()->id)->get();


        $view->with('notifications',$notifications);


    }
}
