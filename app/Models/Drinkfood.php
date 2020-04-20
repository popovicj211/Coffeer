<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class Drinkfood
{

    private $start;
    private $length;
    private $cat;
    private $dfImg;
    /**
     * @param mixed $cat
     */
    public function setCat($cat): void
    {
        $this->cat = $cat;
    }

    /**
     * @return mixed
     */
    public function getCat()
    {
        return $this->cat;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }




    public function getAllCategories()
    {
        return DB::table('categories')->get();
    }

    public function getAllDiscounts(){
         return DB::table('discount')->get();
    }


            public function getAllDrinksFoods(){
                     return DB::table('categories AS c')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->select('c.name AS catname','df.*', 'img.*' , 'di.percent'  )->paginate(3);
                   }

    public function getAllDrinksFoodsDiscount(){
        return DB::table('drinkfood AS df')->select('df.*', 'img.*' , 'di.percent')->join('images2 AS img','df.img_id','=','img.img_id')->join('discount AS di','df.dis_id','=' , 'di.dis_id')->paginate(3);
    }

           public function getFilterDrinksFoods(){
               return DB::table('categories AS c')->select('c.name AS catname','df.*','img.*' ,'di.percent')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->where('df.cat_id', '=' , $this->cat)->paginate(3);
           }


   // ajax

    public function getAllDrinksFoodsDiscountLimit(){
        return DB::table('drinkfood as df')->select('df.*', 'img.*' , 'di.percent')->join('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->offset($this->start)->limit($this->length)->get();
    }

    public function countsDiscount(){
        return DB::table('drinkfood AS df')->join('discount AS dis' , 'df.dis_id' , '=' , 'dis.dis_id')->join('images2 as i' , 'df.img_id' , '=' , 'i.img_id')->count('df.df_id');
    }

    public function getAllDrinksFoodsLimit(){
        return DB::table('categories AS c')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->select('c.name AS catname','df.*', 'img.*' , 'di.percent'  )->offset($this->start)->limit($this->length)->get();
    }

    public function countsDfs(){
        return DB::table('drinkfood AS df')->count('df_id');
    }

    public function getFilterDrinksFoodsCat(){
        return DB::table('categories AS c')->select('c.name AS catname','df.*', 'img.*' ,'di.percent')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->where('df.cat_id', '=', $this->cat)->offset($this->start)->limit($this->length)->get();
    }

    public function countsCatDfs(){
        return DB::table('drinkfood AS df')->join('categories AS c' , 'df.cat_id' ,'=' , 'c.cat_id')->where('df.cat_id' , $this->cat)->count('df_id');
    }

}
