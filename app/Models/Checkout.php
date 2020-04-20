<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class Checkout
{
       private $street;
       private $placeId;
       private $postcode;
       private $phone;
       private $cardnumber;
       private $paId;
       private $cityId;
       private $userId;
       private $cart;



    /**
     * @param mixed $street
     */
    public function setStreet($street): void
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $placeId
     */
    public function setPlaceId($placeId): void
    {
        $this->placeId = $placeId;
    }

    /**
     * @return mixed
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $cardnumber
     */
    public function setCardnumber($cardnumber): void
    {
        $this->cardnumber = $cardnumber;
    }

    /**
     * @return mixed
     */
    public function getCardnumber()
    {
        return $this->cardnumber;
    }

    /**
     * @param mixed $paId
     */
    public function setPaId($paId): void
    {
        $this->paId = $paId;
    }

    /**
     * @return mixed
     */
    public function getPaId()
    {
        return $this->paId;
    }

    /**
     * @param mixed $cityId
     */
    public function setCityId($cityId): void
    {
        $this->cityId = $cityId;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->cityId;
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


       public function getCities(){
            return DB::table('city')->get();
     }

    public function getMethodPay(){
        return DB::table('paymentmetod')->get();
    }
    public function getPlaces(){
        return DB::table('place')->get();
    }

    public function addCheckout(){
        DB::transaction(function (){
            foreach($this->cart as $ct) {
                DB::table('cart')->insert([
                    'total' => $ct['price'], 'quantity' => $ct['qty'], 'user_id' => $this->userId
                ]);
            }
             for($i = 0; $i < count($this->cart); $i++){
                 $co = DB::getPdo()->lastInsertId() - $i;
                 $cart = DB::getPdo()->lastInsertId();
                 DB::table('cart_checkout')->insert([
                     ['cart_id' => $cart, 'cho_id' => $co]
                 ]);
             }


            DB::table('checkout')->insert(
                ['street' => $this->street , 'plc_id' => $this->placeId ,'postcode' => $this->postcode , 'phone' => $this->phone , 'cardnumber' => $this->cardnumber , 'pa_id' => $this->paId , 'city_id' => $this->cityId]
            );




        });
    }

    /*
     DB::table('checkout AS ch')->join('city AS c', 'ch.city_id', '=' , 'c.city_id')->join('paymentmetod AS pay' , 'ch.pa_id','=' , 'pay.pa_id')->join('place AS plc' , 'ch.plc_id' , '=' , 'plc.plc_id')->get();
*/
}
