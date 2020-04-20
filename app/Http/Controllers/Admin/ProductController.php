<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductAddRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Admin\ProductAdmin;
//use Intervention\Image\ImageManagerStatic as Image;
use App\ImageResize\ImageResize;
use Illuminate\Support\Facades\Log;
class ProductController extends BackendController
{
    private $products;
  private $rimg;

    public function __construct()
    {
        parent::__construct();
        $this->products = new ProductAdmin();
        $this->rimg = new ImageResize();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajaxIndex(Request $request){

        $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $this->products->setStart($start);
        $this->products->setLength($this->perPage);
        $pag = $this->products->getProductsLimit();
        $counts =  $this->products->countProducts();

        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag ,  'count' => $counts  ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show products data in admin with pagination, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;

    }

    public function index()
    {
        try {
            $this->data['products'] = $this->products->getProducts();
           $this->data['category'] = $this->products->category();
           $this->data['discount'] = $this->products->discountProduct();
    }catch (QueryException $e){
            Log::info("Show admin products, error:" . $e->getMessage());
            abort(500);
        }
        return view('pages.admin.product' , $this->data);
     //    return  dd($this->data);
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
    public function store(ProductAddRequest $request)
    {

        $hasFile = $request->hasFile('insPhotoProduct');
        $file = $request->file('insPhotoProduct');

        $this->rimg->setHasFile($hasFile);
        $this->rimg->setFile($file);

        $meniImg = $this->rimg->resizeImg(350,350 );
    /*    $scartImg = $this->rimg->resizeImg(540,540 , "singledf");
        $cartImg = $this->rimg->resizeImg(100,100 , "cart");*/

        $name = $request->input('adminProductAddName');
        $desc = $request->input('adminProductAddDesc');
        $price = $request->input('adminProductAddPrice');
        $this->products->setPrice($price);
         $cat = $request->input('adminProductAddCat');
        $discount = $request->input('adminProductAddDiscount');
          if($discount == 0){
              $disId = NULL;
              $newPrice = NULL;
          }else{
              $disId = $discount;
              $percent =  $price * $discount / 100;
              $newPrice = $price - $percent;
          }

          $this->products->setName($name);
          $this->products->setDesc($desc);

        $this->products->setNewPrice($newPrice);
        $this->products->setDisId( $disId);
        $this->products->setCatId($cat);
        $this->products->setCreated($this->thisDate);
        $this->products->setModified($this->thisDate);

        $this->products->setLink($meniImg['link']);
        $this->products->setAlt($meniImg['alt']);



        try {
            $this->products->addProduct();
        }catch(QueryException $e){
            Log::critical("Add product, error:" . $e->getMessage());
            abort(500);
        }
        return redirect()->back(201)->with('messageAddProduct' , 'Product is successfully added!');

     //   return response()->json(['data' => array($meniImg['link'] , $scartImg['link'] , $cartImg['link']) ]);
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
    public function edit($id , $img)
    {
    //    $idEdit = explode("-" , $id);
        try {
           // $this->products->setDfID($idEdit[0]);
         //   $this->products->setImgID($idEdit[1]);
            $this->products->setDfID($id);
              $this->products->setImgID($img);
            $edit =  $this->products->getOneProduct();
            if($edit){
                $response = response()->json(['data' => $edit],200);
            }else{
                $response = response()->json(null,500);
            }
        }catch (QueryException $e){
            Log::critical("Show product for edit, error:" . $e->getMessage());
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
    public function update(Request $request, $id , $img)
    {

        $photoExist = $request->input('upPhotoProductExist');
        $photoExistLA  = explode("-" , $photoExist);

        $file = $request->file('upPhotoProduct');
        if($file == null){
         //   $photo =  $photoExist;
            $this->products->setLink($photoExistLA[0]);
            $this->products->setAlt($photoExistLA[1]);
        }else{
           // $photo = $file;
            $hasFile = $request->hasFile('upPhotoProduct');
            $this->rimg->setHasFile($hasFile);
            $this->rimg->setFile($file);
            $meniImg = $this->rimg->resizeImg(350,350 );
            $this->products->setLink($meniImg['link']);
            $this->products->setAlt($meniImg['alt']);
        }

        $name = $request->input('adminProductUpdateName');
        $desc = $request->input('adminProductUpdateDesc');
        $price = $request->input('adminProductUpdatePrice');
          $this->products->setPrice($price);
        $cat = $request->input('adminProductUpdateCat');
        $discount = $request->input('adminProductUpdateDiscount');
        if($discount == 0){
            $disId = NULL;
            $newPrice = NULL;
        }else{
            $disId = $discount;
            $percent =  $price * $discount / 100;
            $newPrice = $price - $percent;

        }

        $this->products->setNewPrice($newPrice);
        $this->products->setDisId( $disId);

        $this->products->setName($name);
        $this->products->setDesc($desc);

        $this->products->setCatId($cat);
        $this->products->setModified($this->thisDate);

        $this->products->setImgID($img);
        $this->products->setDfID($id);

             try{
                 $this->products->updateProduct();
                 $response = response()->json(null, 204);
             }catch (QueryException $e){
                 Log::critical("Update product, error:" . $e->getMessage());
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
            $this->products->setImgID($id);
            $this->products->deleteProduct();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Delete product, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }
}
