<?php

namespace App\Http\Controllers;

use App\Repositories\ServiecRequestRepository;
use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use Auth;

class TicketController extends Controller
{
    protected $ticket, $servicerequest;

    public function __construct(TicketRepository $ticket, ServiecRequestRepository $servicerequest)
    {
        $this->ticket = $ticket;
        $this->servicerequest = $servicerequest;
    }


    public function store(Request $request,$id){

        $service = $this->servicerequest->find($id);
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
       $data['servicerequest_id']= $service->id;
        if($this->ticket->create($data)){
            return view('service.ticketlist')->withService($service);
        }
    }

    public function destroy(Request $request,$id){
        $service = $this->servicerequest->find($request->service_id);
        $ticket = $this->ticket->find($id);
        if($this->ticket->destroy($ticket->id)){
            return view('service.ticketlist')->withService($service);
        }
    }
    public function changeStatus(Request $request)
    {

        $service = $this->servicerequest->find($request->service_id);
        $ticket = $this->ticket->find($request->id);
        if ($ticket->is_active == 0) {
            $data['is_active'] = '1';
        } else {
            $data['is_active'] = '0';
        }


        $this->ticket->update($ticket->id, $data);

        return view('service.ticketlist')->withService($service);
    }
}
