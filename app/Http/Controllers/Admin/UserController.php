<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\Menu;
use App\Models\Admin\UserAdmin;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\UserAddRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class UserController extends BackendController
{
    private $users;
    private $role;



    public function __construct()
    {
        parent::__construct();
        $this->users = new UserAdmin();
        $this->role = new Role();
        $this->data['roles'] = $this->role->getRole();

    }

    public function ajaxIndex(Request $request){
        $number = $request->input('numb');
        if($number){
            $start = $this->perPage * ($number - 1);
        }else{
            $start = 0;
        }
        //  $session =  Session::has('user') ? Session::get('user')->user_id : null;
        $this->users->setStart($start);
        $this->users->setLength($this->perPage);
        $pag = $this->users->getUsersLimit();
        $counts =  $this->users->countsUsers();

        try {
            if ($pag && $counts) {
                $response = response()->json(['data' => $pag ,  'count' => $counts  ], 200);
            } else {
                $response = response()->json(null, 500);
            }
        }catch (QueryException $e){
            Log::critical("Show users data in admin with pagination, error:" . $e->getMessage());
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
            $this->data['users'] = $this->users->getUsers();

        }catch (QueryException $e){
            Log::info("Show users, error:" . $e->getMessage());
            abort(500);
        }
        return view('pages.admin.user' , $this->data);
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
    public function store(UserAddRequest $request)
    {

        $name = $request->input("adminUserAddName");
        $usrname = $request->input("adminUserAddUsername");
        $email = $request->input("adminUserAddEmail") ;
        $password = $request->input("adminUserAddPass");
        $token = md5(time().$email);
        $active = $request->input("adminUserAddActive");
        $roleId = $request->input("adminUserAddRole");
          $this->users->setName($name);
          $this->users->setUsrname($usrname);
          $this->users->setEmail($email);
          $this->users->setPassword($password);
          $this->users->setToken($token);
          $this->users->setActive($active);
          $this->users->setRoleId($roleId);

        try {
         $this->users->addUser();

        }catch(QueryException $e){
            Log::critical("Add user, error:" . $e->getMessage());
       //       abort(409);
            return redirect()->back(409)->with('messageAddUser' , 'Email address exist!');
        }
          return redirect()->back(201)->with('messageAddUser' , 'User is successfully added!');

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
             $this->users->setUserID($id);
              $edit =  $this->users->getOneUser();
                if($edit){
                    $response = response()->json(['data' => $edit],200);
                }else{
                    $response = response()->json(null,500);
                }
         }catch (QueryException $e){
             Log::critical("Show user for edit, error:" . $e->getMessage());
             $response = response()->json(null,500);
         }
         return $response;
       // $edit =  $this->users->getOneUser($id);
     //   return dd($edit);
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
      //  return dd($request);

        $name = $request->input("adminUserUpdateName");
        $usrname = $request->input("adminUserUpdateUsername");
        $email = $request->input("adminUserUpdateEmail") ;
        $password = $request->input("adminUserUpdatePass");

              if(isset($password)){
                  $this->users->setPassword($password);
              }

        $active = $request->input("adminUserUpdateRole");
        $roleId = $request->input("adminUserUpdateActive");

         $this->users->setUserID($id);
        $this->users->setName($name);
        $this->users->setUsrname($usrname);
        $this->users->setEmail($email);
         $this->users->setModified($this->thisDate);
        $this->users->setActive($active);
        $this->users->setRoleId($roleId);

        try{
            $this->users->updateUser();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Update users, error:" . $e->getMessage());
            $response = response()->json(null, 500);
         //   abort(500);
        }
       // return redirect()->back(204)->with('messageUpdateUser' , 'User is successfully updated!');
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
            $this->users->setUserID($id);
            $this->users->deleteUser();
            $response = response()->json(null, 204);
        }catch (QueryException $e){
            Log::critical("Delete user, error:" . $e->getMessage());
            $response = response()->json(null, 500);
        }
        return $response;
    }

    public function f(){

    }
}
