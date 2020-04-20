<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class User
{
     private $name;
     private $username;
     private $email;
     private $password;
     private $role;
     private $active;
     private $token;
     private $userId;

     public function setName($name){
           $this->name = $name;
     }

     public function getName(){
         return $this->name;
     }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setEmail($email){
    $this->email = $email;
}

    public function getEmail(){
        return $this->email;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function getRole(){
        return $this->role;
    }

    public function setActive($active){
        $this->active = $active;
    }

    public function getActive(){
        return $this->active;
    }


    public function setToken($token){
        $this->token = $token;
    }

    public function getToken(){
        return $this->token;
    }

    public function createUser(){
         DB::table("user")->insert([
             'name' => $this->name,
             'username' => $this->username,
             'email' => $this->email,
             'password' => md5($this->password),
             'token' => $this->token,
             'active' => $this->active,
             'role_id' => $this->role
         ]);
     }


     public function Activate($token){
               $act = 1;
             DB::table('user')->where('token' , $token)->update(['active' => $act]);
     }

     public function getUser($username , $password){
           return DB::table('user')->where([
                  ['username', '=' , $username] , ['password', '=' , md5($password) ]
           ])->select('user_id' , 'name' , 'username' , 'role_id')->first();
     }

    public function getOneUser($userId){
        $query = DB::table("user as u")
            ->where("user_id",$userId)->first();
        return $query;
    }

}
