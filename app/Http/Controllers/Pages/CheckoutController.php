<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Models\Checkout;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends FrontendController
{
    private $checkout;

    public function __construct() {
        parent::__construct();
        $this->checkout = new Checkout();
        //    $this->data['slide'] = $this->slider->getImgSlide();
    }

    public function Index()
    {
      $this->data['cities'] = $this->checkout->getCities();
        $this->data['paymethod'] = $this->checkout->getMethodPay();
        $this->data['places'] = $this->checkout->getPlaces();
        return view( 'pages.checkout', $this->data);
    }

   /* public function doChechout(CheckoutRequest $request){
       //  return dd($request);
        $cityId = $request->input('city');
        $street = $request->input('street');
        $placeId = $request->input('place');
        $postcode = $request->input('postcode');
        $phone = $request->input('mobile');
        $paId = $request->input('paymethod');
        $cardnumber = $request->input('creditcardnumber');

         $this->checkout->setCityId($cityId);
         $this->checkout->setStreet($street);
         $this->checkout->setPlaceId( $placeId);
         $this->checkout->setPostcode($postcode);
         $this->checkout->setPhone($phone);
         $this->checkout->setPaId($paId);
         $this->checkout->setCardnumber($cardnumber);

          $this->checkout->setUserId($request->session()->get('user')->user_id);
        return dd($request);

    }
*/
}
