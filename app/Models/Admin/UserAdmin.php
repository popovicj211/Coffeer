<?php


namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;

class UserAdmin
{
    private $name;
    private $usrname;
    private $email;
    private $password;
    private $token;
    private $active;
    private $roleId;
    private $userID;
   private $modified;
   private $start;
   private $length;

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $usrname
     */
    public function setUsrname($usrname): void
    {
        $this->usrname = $usrname;
    }

    /**
     * @return mixed
     */
    public function getUsrname()
    {
        return $this->usrname;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId): void
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified): void
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    public function getUsers()
    {
        return DB::table('user AS u')->join('role AS r', 'u.role_id', '=', 'r.role_id')->select('u.user_id', 'u.name', 'u.username', 'u.email', 'u.created', 'u.modified', 'u.active', 'r.role_id', 'r.name AS rolename')->paginate(5);
    }

    public function getUsersLimit()
    {
        return DB::table('user AS u')->join('role AS r', 'u.role_id', '=', 'r.role_id')->select('u.user_id', 'u.name', 'u.username', 'u.email', 'u.created', 'u.modified', 'u.active', 'r.role_id', 'r.name AS rolename')->offset($this->start)->limit($this->length)->get();
    }

    public function getAllUsers(){
        return DB::table('user')->where('role_id' , '=', $this->roleId )->select('user_id' ,'name' , 'email')->get();
    }

    public function countsUsers()
    {
        return DB::table('user')->count('user_id');
    }


    public function addUser()
    {
        return DB::table('user')->insert(
            ['name' => $this->name, 'username' => $this->usrname, 'email' => $this->email, 'password' => md5($this->password), 'token' => $this->token, 'active' => $this->active, 'role_id' => $this->roleId]
        );
    }

    public function getOneUser()
    {
       return DB::table("user")->where("user_id", "=", $this->userID)->select("user_id" ,"name" , "username" , "email" , "active" , "role_id" )->first();

    }


    public function updateUser(){
          if($this->password == null) {
              return DB::table('user')->where('user_id', '=', $this->userID)->update([
                  'name' => $this->name, 'username' => $this->usrname, 'email' => $this->email, 'modified' => $this->modified, 'active' => $this->active, 'role_id' => $this->roleId
              ]);
          }else{
              return DB::table('user')->where('user_id', '=', $this->userID)->update([
                  'name' => $this->name, 'username' => $this->usrname, 'email' => $this->email, 'password' => $this->password, 'modified' => $this->modified, 'active' => $this->active, 'role_id' => $this->roleId
              ]);
          }
    }

    public function deleteUser(){
          return DB::table('user')->where('user_id', '=', $this->userID)->delete();
    }
}
