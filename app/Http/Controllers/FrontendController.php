<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Drinkfood;
use App\Models\Slider;
use Illuminate\Database\QueryException;
use App\Models\Menu;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
 class FrontendController extends Controller
 {
     protected $data;
     protected $menu;
     protected $model;
     protected $slider;
     protected $count;

     public function __construct()
     {

         $this->menu = new Menu();
         $this->data['menus'] = $this->menu->getAllMenu();
         $name = request()->route()->getName();
         $nameupp = strtoupper($name);
         $this->data['menusname'] = $this->menu->getNameMenu($nameupp);
         $this->model = new Drinkfood();
         $this->slider = new Slider();
         $this->data['slide'] = $this->slider->getImgSlide();
         $this->count = new Cart();

     }


     // public abstract function Index();
     public function ajaxCartCount()
     {
         if (Session::has('user')) {
             $session =  Session::has('user') ? Session::get('user')->user_id : null;
             $role =  Session::has('user') ? Session::get('user')->role_id : null;
          //  $this->count->setUserId(Session::get('user')->user_id);
           // $count = $this->count->countsCart();
              if(Session::has('cart')) {
                  $count = count(Session::get('cart')->items);
              }else{
                  $count = 0;
              }
                  try {
                      if (isset($count)) {
                          $response = response()->json(['data' => $count, 'session' => $session , 'role' => $role], 200);
                      } else {
                          $response = response()->json(null, 500);
                      }
                  } catch (QueryException $e) {
                      Log::critical("Navigation product cart, error:" . $e->getMessage());
                      $response = response()->json(null, 500);
                  }
                  return $response;


          }

         }


 }
