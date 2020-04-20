<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\ContactAddRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Admin\ContactAdmin;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log;

class ContactController extends BackendController
{
    private $contact;


    public function __construct()
    {
        parent::__construct();
        $this->contact = new ContactAdmin();
    }

     public function ajaxIndex(Request $request){

         $number = $request->input('numb');
         if($number){
             $start = $this->perPage * ($number - 1);
         }else{
             $start = 0;
         }
         $this->contact->setStart($start);
         $this->contact->setLength($this->perPage);
         $pag = $this->contact->getContactLimit();
         $counts =  $this->contact->countContact();

         try {
             if ($pag && $counts) {
                 $response = response()->json(['data' => $pag ,  'count' => $counts  ], 200);
             } else {
                 $response = response()->json(null, 500);
             }
         }catch (QueryException $e){
             Log::critical("Show contact data in admin with pagination, error:" . $e->getMessage());
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
        try {
            $this->data['contact'] = $this->contact->getContact();
            $this->data['users'] = $this->contact->getAllContacts();
        }catch (QueryException $e){
            Log::info("Show admin contact, error:" . $e->getMessage());
            abort(500);
        }
        return  view('pages.admin.contact' , $this->data);
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
    public function store(ContactAddRequest $request)
    {

        $name = $request->input('adminContactAddName');
        $email = $request->input('adminContactAddEmail');
        $subj = $request->input('adminContactAddSubject');
        $message = $request->input('adminContactAddMessage');


        $this->contact->setName($name);
        $this->contact->setEmail($email);
        $this->contact->setSubj($subj);
        $this->contact->setMessage($message);

        $this->contact->setCreated($this->thisDate);
        $this->contact->setModified($this->thisDate);


        try {
            $this->contact->addContact();
        }catch(QueryException $e){
            Log::critical("Add contact admin, error:" . $e->getMessage());
            abort(500);
        }
        return redirect()->back(201)->with('messageAddCont' , 'Contact is successfully added!');
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

            $this->contact->setCont($id);

            $edit =  $this->contact->getOneContact();
            if($edit){
                $response = response()->json(['data' => $edit],200);
            }else{
                $response = response()->json(null,500);
            }
        }catch (QueryException $e){
            Log::critical("Show contact for edit, error:" . $e->getMessage());
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
        $name = $request->input('adminContactUpdateName');
        $email = $request->input('adminContactUpdateEmail');
        $subj = $request->input('adminContactUpdateSubject');
        $message = $request->input('adminContactUpdateMessage');

       $this->contact->setCont($id);
        $this->contact->setName($name);
        $this->contact->setEmail($email);
        $this->contact->setSubj($subj);
        $this->contact->setMessage($message);
        $this->contact->setModified($this->thisDate);

        try{
            $this->contact->updateContact();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Update contact, error:" . $e->getMessage());
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
            $this->contact->setCont($id);
            $this->contact->deleteContact();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Delete contact, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }

    public function response(Request  $request){

            $contEmail = $request->input('adminContactResponseEmail');
            $message = $request->input('adminContactResponseMessage');
           $contIdEmail = explode("-" , $contEmail);

     /*   try{
            $this->contact->setCont($id);
            $this->contact->deleteContact();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            \Log::critical("Delete contact, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;*/



        try{
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'armygamesict2@gmail.com';                     // SMTP username
                $mail->Password   = 'Ar25Gam2*';                               // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('armygamesict2@gmail.com', 'Registration From');
                $mail->addAddress('armygamesict@gmail.com');     // Add a recipient
                //  $mail->addAddress($contIdEmail[1]);     // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Response contact message';
                $mail->Body   =  $message;

                $mail->send();
                //    echo 'Message has been sent';
                $response = response()->json(null, 200);
            } catch (QueryException $e) {

                Log::info("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");

            }
        }catch (QueryException $e) {
            Log::critical("Response contact message, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }

        return $response;

    }

}
