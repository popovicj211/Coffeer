<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cart\CartAddRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Admin\CartAdmin;
use App\Models\Admin\UserAdmin;
use App\Models\Admin\ProductAdmin;
use Illuminate\Support\Facades\Log;
class CartController extends BackendController
{
   private $cart;
   private $user;
private  $product;
private $total;
private $role = 2;

   public function __construct()
   {
       parent::__construct();
       $this->cart = new CartAdmin();
       $this->user = new UserAdmin();
       $this->product = new ProductAdmin();
   }

    public function ajaxIndex(Request $request)
    {
        $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $this->cart->setRoleId($this->role);
        $this->cart->setStart($start);
        $this->cart->setLength($this->perPage);

        $pag = $this->cart->getCartLimit();
        $counts =  $this->cart->countsCart();

        try {
            if (isset($pag)) {
                $response = response()->json(['data' => $pag  , 'counts' => $counts ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show cart data with pagination on Admin panel ,error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;

    }

    public function ajaxIndexFilter(Request $request ){

        $number = $request->input('numb');
        $user = $request->input('filterListUser');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $this->cart->setRoleId($this->role);
        $this->cart->setUserId($user);
        $this->cart->setStart($start);
        $this->cart->setLength($this->perPage);

        $sum = $this->cart->sumTotalPrices();
        $pag = $this->cart->getCartFilterLimit();
        $counts =  $this->cart->countsCartUser();

        try {
            if ($pag && $counts && $sum) {
                $response = response()->json(['data' => $pag ,  'sum' => $sum, 'counts' => $counts  ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show cart filter with pagination, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->user->setRoleId($this->role);
        $this->cart->setRoleId($this->role);
        try {

            $arrQuan = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            $this->data['showcart'] = $this->cart->getCartPaginate();
            $this->data['countcart'] = $this->cart->countsCart();
            $this->data['users'] = $this->user->getAllUsers();
            $this->data['showfiltusers'] = $this->cart->getUserList();
            $this->data['quantity'] = $arrQuan;
            $this->data['products'] = $this->product->getProductsList();
        }catch (QueryException $e){
            Log::info("Show admin cart, error:" . $e->getMessage());
            abort(500);
        }
        return view( 'pages.admin.cart', $this->data);
    }


    public function indexFilter($user){
        $this->user->setRoleId($this->role);
        $this->cart->setRoleId($this->role);
        $this->cart->setUserId($user);
        try {
        $this->data['showcart'] = $this->cart->getFilterCart();
        $this->data['sumtotals'] = $this->cart->sumTotalPrices();
        $this->data['countcart'] = $this->cart->countsCartUser();
        $this->data['users'] = $this->user->getAllUsers();
        $this->data['showfiltusers'] = $this->cart->getUserList();
        $this->data['products'] = $this->product->getProductsList();
        }catch (QueryException $e){
            Log::info("Show admin filter cart, error:" . $e->getMessage());
            abort(500);
        }
        return view('pages.admin.cart' , $this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartAddRequest $request)
    {
          $user = $request->input('adminCartAddUser');
          $productPriceAll = $request->input('adminCartAddProduct');
         $productPrice = explode("-" , $productPriceAll);
          $quantity = $request->input('adminCartAddQuantity');

          $this->total = $quantity * $productPrice[1];

          $this->cart->setDfId($productPrice[0]);
          $this->cart->setUserId($user);
          $this->cart->setQuantity($quantity);
          $this->cart->setTotal($this->total);
          $this->cart->setCreated($this->thisDate);
          $this->cart->setModified($this->thisDate);

        try {
            $this->cart->addCart();
        }catch(QueryException $e){
            Log::critical("Add cart, error:" . $e->getMessage());
            abort(500);
        }
        return redirect()->back(201)->with('messageAddCart' , 'Cart is successfully added!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $this->cart->setCartId($id);
            $edit =  $this->cart->getOneCart();
            if($edit){
                $response = response()->json(['data' => $edit],200);
            }else{
                $response = response()->json(null,500);
            }
        }catch (QueryException $e){
            Log::critical("Show cart for edit, error:" . $e->getMessage());
            $response = response()->json(null,500);
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $request->input('adminCartUpdateUser');
        $productPriceAll = $request->input('adminCartUpdateProduct');
        $productPrice = explode("-" , $productPriceAll);
        $quantity = $request->input('adminCartUpdateQuantity');
        //$cartId = $request->input('');

        $this->total = $quantity * $productPrice[1];

        $this->cart->setCartId($id);
        $this->cart->setDfId($productPrice[0]);
        $this->cart->setUserId($user);
        $this->cart->setQuantity($quantity);
        $this->cart->setTotal($this->total);
        $this->cart->setModified($this->thisDate);

        try{
            $this->cart->updateCart();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Update cart, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->cart->setCartId($id);
            $this->cart->deleteCart();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Delete cart, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }
}
