<?php
namespace   App\Helper\Product;

use App\Models\Device;
use App\Repositories\DeviceRepository;
use Auth;

class  ProductStoreNotification
{
    protected $product, $device;


//    /

    public function sendnotification($product)
    {
        $token = Auth::user()->remember_token;

        $device = Device::where('user_id', $product->created_by)->first();
//            $device_id =[];
//
//            foreach($device as $value){
//                $device_id[] = [
//                    'device_id'=>$value->device_id
//                ];
//            }
        $content = array(
            "en" => 'English Message',
            "title" => $product->title,
            "price" => $product->price,
            "image" => $product->image
        );
        $message = 'delivery successfully';
        $user_id = $device->device_id;


        $fields = array(
            'app_id' => "f04be9cf-7553-42dc-8a7d-0faa61b2811c",
            'include_player_ids' =>[$user_id],
            'contents' => $content
        );


        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic Yzg5YTViZjktOWM2ZS00MDgxLTgzZTAtNzRhNDQ1Y2VmZjZm '));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}



