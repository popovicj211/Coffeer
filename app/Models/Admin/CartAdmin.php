<?php


namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;

class CartAdmin
{

    private $userId;
    private $start;
    private $length;

    private $cartId;
   private $total;
   private $quantity;
   private $dfId;
   private $created;
   private $modified;
   private $roleId;

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
     * @param mixed $dfId
     */
    public function setDfId($dfId): void
    {
        $this->dfId = $dfId;
    }

    /**
     * @return mixed
     */
    public function getDfId()
    {
        return $this->dfId;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified): void
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $cartId
     */
    public function setCartId($cartId): void
    {
        $this->cartId = $cartId;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId): void
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    public function getCartPaginate(){
        return   DB::table('images2 AS img')->join('drinkfood AS df' , 'img.img_id' , '=' , 'df.img_id')->join('cart_drinkfood AS cdf' , 'df.df_id' , '=' , 'cdf.df_id')->leftJoin('cart AS c' , 'cdf.cart_id' , '=' , 'c.cart_id')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->select('u.name AS nameuser','u.email', 'u.role_id','img.link' , 'img.alt' , 'df.*' , 'c.*' )->where('role_id' ,'=' , $this->roleId)->orderBy('c.created' , 'asc')->paginate(5);

    }

    public function getFilterCart(){
        return DB::table('images2 AS img')->join('drinkfood AS df' , 'img.img_id' , '=' , 'df.img_id')->join('cart_drinkfood AS cdf' , 'df.df_id' , '=' , 'cdf.df_id')->leftJoin('cart AS c' , 'cdf.cart_id' , '=' , 'c.cart_id')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->select('u.name AS nameuser','u.email','u.role_id' ,'img.link' , 'img.alt' , 'df.*' , 'c.*' )->where([['c.user_id',  $this->userId],['u.role_id', $this->roleId]])->paginate(5);
    }


    public function getUserList(){
        return DB::table('cart AS c')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->select('c.user_id','u.name AS nameuser','u.email' )->groupBy('user_id')->get();
    }


    public function sumTotalPrices(){
        return   DB::table('cart as c' )->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->where([['c.user_id'  , $this->userId],['u.role_id' , $this->roleId]])->sum('total');
    }

    public function countsCart(){
        return DB::table('cart as c')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->where('u.role_id' , '=' , $this->roleId)->count('cart_id');
    }

    public function countsCartUser(){
        return DB::table('cart as c')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->where([['c.user_id' , $this->userId],['u.role_id' , $this->roleId]])->count('cart_id');
    }


    public function getCartLimit(){
        return   DB::table('images2 AS img')->join('drinkfood AS df' , 'img.img_id' , '=' , 'df.img_id')->join('cart_drinkfood AS cdf' , 'df.df_id' , '=' , 'cdf.df_id')->leftJoin('cart AS c' , 'cdf.cart_id' , '=' , 'c.cart_id')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->select('u.name AS nameuser', 'u.role_id','u.email','img.link' , 'img.alt' , 'df.*' , 'c.*' )->where('u.role_id','=',$this->roleId)->orderBy('c.created' , 'asc')->offset($this->start)->limit($this->length)->get();

    }

    public function getCartFilterLimit(){
        return   DB::table('images2 AS img')->join('drinkfood AS df' , 'img.img_id' , '=' , 'df.img_id')->join('cart_drinkfood AS cdf' , 'df.df_id' , '=' , 'cdf.df_id')->leftJoin('cart AS c' , 'cdf.cart_id' , '=' , 'c.cart_id')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->select('u.name AS nameuser','u.email','img.link','u.role_id','img.alt' , 'df.*' , 'c.*' )->where([['c.user_id' , $this->userId],['u.role_id' , $this->roleId]])->orderBy('c.created' , 'asc')->offset($this->start)->limit($this->length)->get();

    }

    public function addCart(){
            DB::transaction(function (){
                DB::table('cart')->insert([
                    'total' => $this->total , 'quantity' => $this->quantity , 'user_id' => $this->userId , 'created' => $this->created , 'modified' => $this->modified
                ]);

                $cartId = DB::getPdo()->lastInsertId();
                   DB::table('cart_drinkfood')->insert([
                       'cart_id' => $cartId , 'df_id' => $this->dfId
                   ]);

            });
    }


    public function getOneCart(){
        return   DB::table('drinkfood AS df')->join('cart_drinkfood AS cdf' , 'df.df_id' , '=' , 'cdf.df_id')->leftJoin('cart AS c' , 'cdf.cart_id' , '=' , 'c.cart_id')->join('user AS u' , 'c.user_id' , '=' , 'u.user_id')->select( 'u.name AS nameuser', 'u.role_id','u.email','df.df_id', 'df.price', 'df.newprice' , 'c.cart_id' , 'c.quantity' , 'c.total' , 'c.user_id' )->where([['c.cart_id'  , $this->cartId],['u.role_id' , $this->roleId]])->orderBy('c.created' , 'asc')->first();

    }

    public function updateCart(){
        DB::transaction(function (){
            DB::table('cart')->where('cart_id' , '=', $this->cartId)->update([
                'total' => $this->total , 'quantity' => $this->quantity , 'user_id' => $this->userId ,  'modified' => $this->modified
            ]);

            DB::table('cart_drinkfood')->where('cart_id' , '=' , $this->cartId)->update([
                'cart_id' => $this->cartId , 'df_id' => $this->dfId
            ]);

        });
    }

    public function deleteCart(){
        DB::table('cart')->where('cart_id' , '=' , $this->cartId)->delete();
    }


}
