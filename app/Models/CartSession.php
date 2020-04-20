<?php


namespace App\Models;


class CartSession
{

    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

     public function __construct($oldCart)
     {
         if($oldCart){
             $this->items = $oldCart->items;
             $this->totalQty = $oldCart->totalQty;
             $this->totalPrice = $oldCart->totalPrice;
         }
     }





    public function add($item,$id , $quant){
    //    $storedItem = ['qty'=> 0 ,'price'=>'0','item'=>$item];
       $storedItem = ['qty'=> 0 ,'price'=>0,'item'=>$item];
        if($this->items){
            if (array_key_exists($id,$this->items)){
                $storedItem = $this->items[$id];
            }
        }

        $storedItem['qty'] = $quant;
         if($item->newprice == null){
             $storedItem['price'] = $item->price * $storedItem['qty'];
         }else{
             $storedItem['price'] = $item->newprice * $storedItem['qty'];
         }
        $this->items[$id] = $storedItem;
        $this->totalQty += $storedItem['qty'];

            foreach($this->items as $i){
                       $this->totalPrice += $i['price'];
            }

    }

    public function delete($id){
        $this->totalPrice -=$this->items[$id]['price'];
        $this->totalQty -= $this->items[$id]['qty'];
        unset($this->items[$id]);

    }



}
