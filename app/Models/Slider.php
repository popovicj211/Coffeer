<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
class Slider
{
     public function getAllSlides(){
         return  DB::table('slider AS s')->select('s.*','img.link')->join('images2 AS img','s.img_id' , '=','img.img_id')->get();
     }

     public function getImgSlide(){
         return  DB::table('slider AS s')->select('img.link')->join('images2 AS img','s.img_id' , '=','img.img_id')->orderBy('s.slide_id','desc')->first();
     }

}
