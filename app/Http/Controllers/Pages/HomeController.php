<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\FrontendController;
use App\Models\Menu;
use App\Models\Slider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class HomeController extends FrontendController
{
     private $res;
   private $perPage = 3;

   private $merid;
    public function __construct() {
        parent::__construct();
           $this->res = new Reservation();
    }

    public function Index()
    {
        $this->data['slides'] = $this->slider->getAllSlides();
        $this->data['discount'] = $this->model->getAllDrinksFoodsDiscount();
        return view( 'pages.home', $this->data);
    }

    public function Reservation(ReservationRequest $request){
          /*   $timeMeridiem =  $request->input('restime');
              $meridiem = substr( $timeMeridiem , -2);
              $time = strstr($timeMeridiem, $meridiem, true);
              $date = $request->input('resdate');
                  $datearr = explode('/' ,  $date);
                   $dateline = $datearr[2]."-".$datearr[0]."-".$datearr[1];
                   $datetime = $dateline." ".$time;*/
          $date = $request->input('resdate');
          $time = $request->input('restime');
           $datetimeArr = array($date, $time);
        $datetime = implode(" " , $datetimeArr );

    /*    $mob = $request->input('resmob');
            $mobNoSpace = str_replace(' ', '', $mob);
            $mobNoSpaceZero = "0".$mobNoSpace;*/
        $this->res->setUserId($request->session()->get('user')->user_id);
        $this->res->setDate($datetime);
        $this->res->setMob($request->input('resmob'));
        $this->res->setMsg( $request->input('resmsg'));



        try{
              $this->res->createRes();

        }catch (QueryException $e){
            Log::info("Reservation is not ok:" . $e->getMessage());
            abort(500);
        }
        return  redirect()->back(201)->with('msgReservation' , 'Reservation is successfully added!');

    }

    public function ajaxDfspag(Request $request){

        $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $this->model->setStart($start);
        $this->model->setLength($this->perPage);

        $pag = $this->model->getAllDrinksFoodsDiscountLimit();
        $counts =  $this->model->countsDiscount();
        $session =  Session::has('user') ? Session::get('user')->user_id : null;
        //  dd($request->input('numb'));
        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag  , 'count' => $counts , 'session' => $session], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show discount product data with pagination, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }



}
