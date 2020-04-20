<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class SingleProduct
{
    private $dfc;
    private $quantity;
    private $total;
    private $userId;
    private $dfImg;


    /**
     * @param mixed $dfc
     */
    public function setDfc($dfc): void
    {
        $this->dfc = $dfc;
    }

    /**
     * @return mixed
     */
    public function getDfc()
    {
        return $this->dfc;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }



    public function getCartDFSingle($df){

        return DB::table('drinkfood AS df')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->select('df.*', 'img.*'  , 'di.percent' )->where('df.df_id' ,'=',  $df)->first();
    }

  /*  public function modifyQuantity(){
        DB::table('cart_drinkfood')->where('df_id' , $this->dfc)->update(['quantity' => $this->quantity]);
    }*/

    public  function  createCart(){


        DB::transaction(function (){

          /*  DB::table('cart')->insert([
                ['total' => $this->total , 'quantity' => $this->quantity ,'user_id' => $this->userId]
            ]);
            $cartID = DB::getPdo()->lastInsertId();
            DB::table('cart_drinkfood')->insert([
                [ 'cart_id' => $cartID , 'df_id' => $this->dfc]
            ]);

            DB::table('cart_checkout')->insert([
                [ 'cart_id' => $cartID ]
            ]);*/

            DB::table('cart')->insert(
                ['total' => $this->total , 'quantity' => $this->quantity ,'user_id' => $this->userId]
            );
            $cartID = DB::getPdo()->lastInsertId();
            DB::table('cart_drinkfood')->insert(
                [ 'cart_id' => $cartID , 'df_id' => $this->dfc]
            );

            DB::table('cart_checkout')->insert(
                [ 'cart_id' => $cartID ]
            );

        });
   //   return dd($this->cartID);
    }




}
