<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FrontendController;
use App\Models\Cart;
use App\Models\SingleProduct;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\CartSession;

class SingleProductController extends FrontendController
{
    private $spc;
     private $cart;

       private $df;
        private $usr;
       private $quant;
       private $total;

    public function __construct() {
        parent::__construct();
        $this->spc = new SingleProduct();
        $this->cart = new Cart();
     //  $this->data['slide'] = $this->slider->getImgSlide();
    }

    public function Index($sp=1)
    {
        $this->data['singleproduct'] =  $this->spc->getCartDFSingle($sp);
        return view( 'pages.cartsingle', $this->data);
    }


    public function addToCart(Request $request){

     if($request) {

         $this->df = $request->input('dfsingleproduct');
         $this->quant = $request->input('quantity');
         $this->usr = $request->input('usrsingleproduct');
         $this->spc->setDfc($this->df);
         $this->spc->setQuantity($this->quant);
         $this->spc->setUserId($this->usr);

         $newprice = $this->spc->getCartDFSingle($this->df)->newprice;
         $price = $this->spc->getCartDFSingle($this->df)->price;

         if($newprice != null){
             $this->total = $newprice * $this->quant;
             $this->spc->setTotal($this->total);
         }else{
             $this->total = $price * $this->quant;
             $this->spc->setTotal($this->total);
         }



        /* try{
       $this->spc->createCart();
            }catch(QueryException $e){
             Log::critical("Add to cart, error:" . $e->getMessage());
             $response = response()->json(null, 500);
         }*/
       //      $response = response()->json(null , 200);

         }
     /*else{
         $response = response()->json(null, 500);
         }
        return $response;*/

        $product = $this->spc->getCartDFSingle($this->df);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartSession($oldCart);
        $cart->add($product, $this->df , $this->quant);
        $request->session()->put('cart',$cart);
    }



    public function rt()
    {
       return dd(Session::get('cart'));
    }



}
