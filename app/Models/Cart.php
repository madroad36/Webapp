<?php

namespace App\Models;



use Illuminate\Support\Facades\Session;
use Cache;


class Cart
{
    public $items;
    public $totalItem = 0;
    public $totalPrice = 0;

    public function __construct($oldcart)
    {
        if($oldcart){
            $this->items = $oldcart->items;
            $this->totalItem = $oldcart->totalItem;
            $this->totalPrice = $oldcart->totalPrice;
        }
    }

    public function add($item, $id,$peice,$slug){
        Cache::put( 'cart',  ['peice'=>$peice,'price'=>$item->price, 'item'=>$item,'slug'=>$slug]);
        $storedItem = ['peice'=>$peice,'price'=>$item->price, 'item'=>$item,'slug'=>$slug];
        if($this->items){
            if(array_key_exists($id, $this->items)){

                $storedItem  = $this->items[$id];
                $storedItem['peice']= $peice;
                $storedItem['slug']= $slug;
                $storedItem['price']= $peice * $item->price;
                $this->totalItem--;

            }
        }

        $storedItem['peice']= $peice;
        $storedItem['slug']= $slug;
        $storedItem['price']= $peice * $item->price;
        $this->items[$id] =$storedItem ;


        $this->totalItem  = count($this->items);
//        $this->totalPrice += $storedItem['price'];
        $this->location = 'this is test';
    }

}
