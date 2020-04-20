<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class LoginController extends Controller
{
     private $data;
     private $user;

    private $token;
    private $active;
    private $role;

    public function __construct()
     {
            $this->user = new User();
     }

    public function authorizationFormsShow(){
              return view('pages.register');
     }
     public function doRegister(RegisterUserRequest $request)
     {
           $this->token = md5(time().$request->input("email"));
         $this->active = 0;
         $this->role = 2;

         $this->user->setName($request->input("name"));
         $this->user->setUsername($request->input("username"));
         $this->user->setEmail($request->input("email"));
         $this->user->setPassword($request->input("password"));
         $this->user->setToken($this->token);
         $this->user->setActive($this->active);
         $this->user->setRole($this->role);

         try{
             $this->user->createUser();
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
               //  $mail->addAddress($request->input('email'));     // Add a recipient

                 // Content
                 $mail->isHTML(true);                                  // Set email format to HTML
                 $mail->Subject = 'Activate your account';
                 $href = url('/')."/activate/".$this->token;
                 $mail->Body   = 'To activate your account please fallow <a href="' . $href . '">this</a> link';

                 $mail->send();
             //    echo 'Message has been sent';
                  $request->session()->put('verify' , 'Please verify your account on email!');
             } catch (QueryException $e) {

                 Log::info("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");

             }
         }catch (QueryException $e) {
             Log::info("Registration is failed:" . $e->getMessage());
         }

         return redirect()->route('authorization');

     }


     public function Act($token){
             $this->data['token'] = $this->user->Activate($token);
             session()->forget('verify');
             session()->put('verifymsg' , 'Register is complete!');

             return redirect()->route('menu');

     }

   /*  public function showLoginForm(){
         return view('pages.login');
     }*/

    public function doLogin(Request  $request){

         if($request->has('btnlogin')){
                  $username = $request->input('loginusername');
                   $password = $request->input('loginpassword');
               $userSession = $this->user->getUser($username, $password );
                 if($userSession){
                     $request->session()->put('user' , $userSession);
                    $roleId = $request->session()->get('user')->role_id;
                    if($roleId != 1){
                        return redirect()->route('menu');
                    }else{
                        return redirect()->route('users-admin.index');
                    }
                 }else{
                     return redirect()->route('home');
                 }
         }

    }

    public function Logout(Request $request){
         if($request->session()->has('user')){
               $request->session()->forget('user');
               $request->session()->flush();
         }
         return redirect()->route('home');
    }



}
