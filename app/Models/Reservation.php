<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class Reservation
{

    private $date;
    private $mob;
    private $msg;
   private $userId;

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @param mixed $mob
     */
    public function setMob($mob): void
    {
        $this->mob = $mob;
    }

    /**
     * @return mixed
     */
    public function getMob()
    {
        return $this->mob;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg): void
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }


    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function createRes(){
        DB::table('reservation')->insert([
              'date' => $this->date,
               'mobile' => $this->mob,
                'message' => $this->msg,
                   'user_id' => $this->userId
        ]);
    }

}
