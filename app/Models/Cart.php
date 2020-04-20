<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class Cart
{

    private $userId;
    private $start;
    private $length;
    private $cartId;

    private $cart;

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
     * @param mixed $cart
     */
    public function setCart($cart): void
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }


    public function getCartPaginate()
    {
        return DB::table('images2 AS img')->join('drinkfood AS df', 'img.img_id', '=', 'df.img_id')->join('cart_drinkfood AS cdf', 'df.df_id', '=', 'cdf.df_id')->join('cart AS c', 'cdf.cart_id', '=', 'c.cart_id')->where('c.user_id', '=', $this->userId)->select('img.link', 'img.alt', 'df.*', 'c.*')->orderBy('c.created', 'asc')->paginate(5);

    }

    public function sumTotalPrices()
    {
        return DB::table('cart')->where('user_id', $this->userId)->sum('total');
    }


    public function countsCart()
    {
        return DB::table('cart')->where('user_id', '=', $this->userId)->count('cart_id');
    }


    public function getCartLimit()
    {
        return DB::table('images2 AS img')->join('drinkfood AS df', 'img.img_id', '=', 'df.img_id')->join('cart_drinkfood AS cdf', 'df.df_id', '=', 'cdf.df_id')->join('cart AS c', 'cdf.cart_id', '=', 'c.cart_id')->where('c.user_id', '=', $this->userId)->select('img.link', 'img.alt', 'df.*', 'c.*')->orderBy('c.created', 'asc')->offset($this->start)->limit($this->length)->get();

    }

    public function deleteCart()
    {
        DB::table('cart')->where('cart_id', '=', $this->cartId)->delete();
    }


    public function addCart()
    {
        DB::transaction(function () {
            foreach ($this->cart as $ct) {
                DB::table('cart')->insert([
                    'total' => $ct['price'], 'quantity' => $ct['qty'], 'user_id' => $this->userId
                ]);
            }
            foreach ($this->cart as $key => $ct) {
                DB::table('cart_drinkfood')->insert([
                    'cart_id' => DB::getPdo()->lastInsertId() , 'df_id' => $key
                ]);
            }

        });

    }
}
