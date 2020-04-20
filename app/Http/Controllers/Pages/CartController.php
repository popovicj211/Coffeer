<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Models\CartSession;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Checkout;
class CartController extends FrontendController
{
    private $cart;
 private $perPage = 6;

 private  $co;

    public function __construct() {
        parent::__construct();
            $this->cart = new Cart();
   //    $this->data['slide'] = $this->slider->getImgSlide();
        $this->co = new Checkout();
    }

    public function Index()
    {
        $usr = 0;
        if(Session::has('user')) {
            $usr = Session::get('user')->user_id;
        }
             $this->cart->setUserId($usr);

        //   $this->data['showcart'] = $this->cart->getCartPaginate();
       //     $this->data['sumtotals'] = $this->cart->sumTotalPrices();
         //   $this->data['countcart'] = $this->cart->countsCart();

        $oldCard = Session::get('cart');
        $cart = new CartSession($oldCard);
            $this->data['products'] = $cart->items;
             $rt = 0;
             if(Session::has('cart')) {
                 foreach ($cart->items as $c) {
                     $rt += $c['price'];
                 }
             }
        $this->data['totals'] = $rt;
        return view( 'pages.addtocart', $this->data);

    }


  /*  public function ajaxCartDfspag(Request $request){
        $userId = Session::has('user') ? Session::get('user')->user_id : null;
       $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }

        $this->cart->setUserId($userId);
        $this->cart->setStart($start);
        $this->cart->setLength($this->perPage);
       $pag = $this->cart->getCartLimit();
        $sum = $this->cart->sumTotalPrices();
        $counts =  $this->cart->countsCart();
        try {
            if (isset($pag) && isset($sum)) {
                $response = response()->json(['data' => $pag , 'sum' => $sum , 'counts' => $counts ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show cart data with pagination ,error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }
*/

    public function addCartData(Request $request){

        $data = $request->session()->get('cart')->items;
            if($data) {
              $this->cart->setCart($data);
              //   $this->co->setCart($data);
              //   $this->co->setUserId($request->session()->get('user')->user_id);
                $this->cart->setUserId($request->session()->get('user')->user_id);
                $this->cart->addCart();
               //  $this->co->addCheckout();
                $response = response()->json(null, 201);
            } else {
                $response = response()->json(null, 500);
            }

            return $response;
    }

/*
    public function destroy($id){

        $this->cart->setCartId($id);

         try {
                   $this->cart->deleteCart();
                 $response = response()->json(null, 200);

         }catch (QueryException $e){
             Log::critical("Delete product cart ,error:" . $e->getMessage());
             $response = response()->json(null, 500);
         }
        return $response;


    }
*/

/*
    public function cart(){

        $oldCard = Session::get('cart');
        $cart = new CartSession($oldCard);
        return view('pages.cart',['products'=>$cart->items,'totalPrice'=>$cart->totalPrice]);
    }

*/


    public function deleteFromCart($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartSession($oldCart);
        $cart->delete($id);
        Session::put('cart',$cart);
        return redirect()->route('cart');

    }


}
