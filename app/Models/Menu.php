<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class Menu
{
         public function getAllMenu(){
              return DB::table("menu")->get();
         }

    public function getNameMenu($name){
        return DB::table("menu")->where('name', '=' , $name)->first();
    }

}
