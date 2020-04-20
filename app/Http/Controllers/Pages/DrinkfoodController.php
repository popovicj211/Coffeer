<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\FrontendController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Drinkfood;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class DrinkfoodController extends FrontendController
{
      private $viewdf = 'pages.menu';
      private $perPage = 3;
    public function __construct() {
          parent::__construct();
       // $this->data['slide'] = $this->slider->getImgSlide();
        $this->data['categories'] = $this->model->getAllCategories();

    }


    public function Index()
    {
          $this->data['drinks'] =  $this->model->getAllDrinksFoods();
        return view( $this->viewdf, $this->data);
    }

    public function MenuDrinkFoodFilter($cat){
        $this->model->setCat($cat);
        $this->data['drinks'] = $this->model->getFilterDrinksFoods();
        return view($this->viewdf , $this->data);
    }

    public function Paginate(){
        $this->data['drinks'] = $this->model->getAllDrinksFoods();
        return view($this->viewdf , $this->data);
    }

    public function ajaxDfspag(Request $request){

        $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $session =  Session::has('user') ? Session::get('user')->user_id : null;
        $this->model->setStart($start);
        $this->model->setLength($this->perPage);
        $pag = $this->model->getAllDrinksFoodsLimit();
        $counts =  $this->model->countsDfs();

        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag ,  'count' => $counts , 'session' => $session], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show drink and food data with pagination, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }


    public function ajaxDfspagFilter(Request $request){

        $number = $request->input('numb');
       $cat = $request->input('cat');
       if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $sessionfilt =  Session::has('user') ? Session::get('user')->user_id : null;
         $this->model->setCat($cat);
         $this->model->setStart($start);
         $this->model->setLength($this->perPage);
        $pag = $this->model->getFilterDrinksFoodsCat();
        $counts =  $this->model->countsCatDfs();

        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag ,  'count' => $counts ,'session' => $sessionfilt ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Drink and food filter data with pagination, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;

    }

        public function ajaxshowcat(){
              $pag = $this->model->getAllCategories();

            try {
                if ($pag) {
                    $response = response()->json(['data' => $pag ], 200);
                } else {
                    $response = response()->json(null, 500);
                }
            }catch (QueryException $e){
                Log::critical("Drink and food filter data with pagination, error:" . $e->getMessage());
                $response = response()->json(null, 500);
            }
            return $response;
        }

}
