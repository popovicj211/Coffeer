<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\FrontendController;
use App\Models\Contact;
use Carbon\Traits\Date;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Log;
class ContactController extends FrontendController
{
    private $cont;
  private $date;
    public function __construct() {
        parent::__construct();
        $this->data['slide'] = $this->slider->getImgSlide();
        $this->cont = new Contact();
        $this->date = date("Y-m-d H:i:s");
    }

    public function Index(){
        return view('pages.contact', $this->data);
    }

    public function  doContact(ContactRequest $request){

        $name = $request->input('contactname');
        $email = $request->input('contactemail');
        $subj = $request->input('contactsubject');
        $msg = $request->input('contactmsg');
          $this->cont->setName($name);
          $this->cont->setEmail($email);
          $this->cont->setSubj($subj);
          $this->cont->setMsg($msg);
          $this->cont->setCreated($this->date);
          $this->cont->setModified($this->date);

        try{
            $this->cont->createContact();
        }catch (QueryException $e){
            Log::info("Contact is not ok:" . $e->getMessage());
        }
        return redirect()->route('contact');
    }
}
