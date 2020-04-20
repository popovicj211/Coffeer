<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\SliderAddRequest;
use App\Models\Admin\SliderAdmin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\ImageResize\ImageResize;
use Illuminate\Support\Facades\Log;
class SliderController extends BackendController
{
    private $slider;
    private $rimg;
    public function __construct()
    {
        parent::__construct();
        $this->slider = new SliderAdmin();
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
        $this->slider->setStart($start);
        $this->slider->setLength($this->perPage);
        $pag = $this->slider->getSlidersLimit();
        $counts =  $this->slider->countSldier();

        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag ,  'count' => $counts  ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show sliders data in admin with pagination, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;

    }

    public function index()
    {
        try{
            $this->data['slider'] = $this->slider->getSliders();

            }catch (QueryException $e){
              Log::info("Show admin slides, error:" . $e->getMessage());
             abort(500);
          }
          return view('pages.admin.slider' , $this->data);
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
    public function store(SliderAddRequest $request)
    {
        $hasFile = $request->hasFile('insPhotoSlide');
        $file = $request->file('insPhotoSlide');

        $this->rimg->setHasFile($hasFile);
        $this->rimg->setFile($file);

        $meniImg = $this->rimg->resizeImg(1000,750 );
        /*    $scartImg = $this->rimg->resizeImg(540,540 , "singledf");
            $cartImg = $this->rimg->resizeImg(100,100 , "cart");*/

        $name = $request->input('adminSlideAddName');
        $desc = $request->input('adminSlideAddDesc');


        $this->slider->setName($name);
        $this->slider->setText($desc);

        $this->slider->setLink($meniImg['link']);
        $this->slider->setAlt($meniImg['alt']);


        try {
            $this->slider->addSlide();
        }catch(QueryException $e){
            Log::critical("Add slide, error:" . $e->getMessage());
            abort(500);
        }
        return redirect()->back(201)->with('messageAddSlide' , 'Slide is successfully added!');
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
    public function edit($id, $img)
    {
        try {
            $this->slider->setSlideId($id);
            $this->slider->setImgId($img);
            $edit =  $this->slider->getOneSlide();
            if($edit){
                $response = response()->json(['data' => $edit],200);
            }else{
                $response = response()->json(null,500);
            }
        }catch (QueryException $e){
            Log::critical("Show slide for edit, error:" . $e->getMessage());
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



        $file =  $request->file('upPhotoSlide');
     //   $fileTf = isset($file) ? $file : null;
        if(empty($file)){
            //   $photo =  $photoExist;
            $photoExist = $request->input('upPhotoSlideExist');
            $photoExistLA  = explode("*-*" , $photoExist);
            $this->slider->setLink($photoExistLA[0]);
            $this->slider->setAlt($photoExistLA[1]);
        }else{
            // $photo = $file;
            $hasFile = $request->hasFile('upPhotoSlide');
            $this->rimg->setHasFile($hasFile);
            $this->rimg->setFile($file);
            $meniImg = $this->rimg->resizeImg(1000,750 );
            $this->slider->setLink($meniImg['link']);
            $this->slider->setAlt($meniImg['alt']);
        }

        $name = $request->input('adminSlideUpdateName');
        $desc = $request->input('adminSlideUpdateText');




        $this->slider->setName($name);
        $this->slider->setText($desc);


        $this->slider->setImgId($img);
        $this->slider->setSlideId($id);

        try{
            $this->slider->updateSldie();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Update slide, error:" . $e->getMessage());
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
            $this->slider->setImgId($id);
            $this->slider->deleteSlide();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Delete slide, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }
}
