<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class AuthorController extends FrontendController
{
    public function __construct() {
        parent::__construct();

     //   $this->data['slide'] = $this->slider->getImgSlide();
    }
         public function Index()
         {

             return view('pages.author'  , $this->data);
         }

         public function CountsCrt($usr){
              $this->catrtCount($usr);
         }
}
