<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reservation\ResAddRequest;
use App\Models\Admin\ReservationAdmin;
use App\Models\Admin\UserAdmin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log;
class ReserationController extends BackendController
{
    private $res;
    private $user;
    public function __construct()
    {
        parent::__construct();
        $this->res = new ReservationAdmin();
        $this->user = new UserAdmin();
    }


    public function ajaxIndex(Request $request){
        $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        $this->res->setStart($start);
        $this->res->setLength($this->perPage);
        $pag = $this->res->getReservationLimit();
        $counts =  $this->res->countReservation();

        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag ,  'count' => $counts  ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show reservation data in admin with pagination, error:" . $e->getMessage());
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
        try{
           $this->user->setRoleId(2);
            $this->data['reservation'] = $this->res->getReservation();
            $this->data['users'] = $this->user->getAllUsers();
        }catch (QueryException $e){
            Log::info("Show admin reservation, error:" . $e->getMessage());
            abort(500);
        }
            return view('pages.admin.reservation', $this->data);
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
    public function store(ResAddRequest $request)
    {
        $date = $request->input('adminResAddDate');
        $time = $request->input('adminResAddTime');
        $arrDateTime = array($date,$time);
        $mob = $request->input('adminResAddMobile');
        $message = $request->input('adminResAddMessage');
        $userId = $request->input('adminResAddUser');
        $newDateTime = implode(" ",  $arrDateTime );

        $this->res->setUserId($userId);
        $this->res->setDateTime($newDateTime);
        $this->res->setMob($mob);
        $this->res->setMsg($message);

        $this->res->setCreated($this->thisDate);
        $this->res->setModified($this->thisDate);

        try {
            $this->res->addReservation();
        }catch(QueryException $e){
            Log::critical("Add reservation admin, error:" . $e->getMessage());
            abort(500);
        }
        return redirect()->back(201)->with('messageAddRes' , 'Reservation is successfully added!');
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

            $this->res->setResId($id);

            $edit =  $this->res->getOneReservation();
            if($edit){
                $response = response()->json(['data' => $edit],200);
            }else{
                $response = response()->json(null,500);
            }
        }catch (QueryException $e){
            Log::critical("Show reservation for edit, error:" . $e->getMessage());
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

        $date = $request->input('adminResUpDate');
        $time = $request->input('adminResUpTime');
        $arrDateTime = array($date,$time);
        $mob = $request->input('adminResUpMobile');
        $message = $request->input('adminResUpMessage');
        $userId = $request->input('adminResUpUser');
        $newDateTimeUp = implode(" ",  $arrDateTime );

        $this->res->setResId($id);
        $this->res->setUserId($userId);
        $this->res->setDateTime($newDateTimeUp);
        $this->res->setMob($mob);
        $this->res->setMsg($message);

        $this->res->setModified($this->thisDate);



        try{
            $this->res->updateReservation();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Update reservation, error:" . $e->getMessage());
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
            $this->res->setResId($id);
            $this->res->deleteReservation();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Delete reservation, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }

    public function response(Request  $request){

        $resEmail = $request->input('adminResResponseEmail');
        $message = $request->input('adminResResponseMessage');
        $contIdEmail = explode("-" , $resEmail);

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
                $mail->Subject = 'Response reservation message';
                $mail->Body   =  $message;

                $mail->send();
                //    echo 'Message has been sent';
                $response = response()->json(null, 200);
            } catch (QueryException $e) {

                Log::info("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");

            }
        }catch (QueryException $e) {
            Log::critical("Response reservation message, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }

        return $response;

    }

}
