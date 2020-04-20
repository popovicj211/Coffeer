<?php


namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;

class ReservationAdmin
{
   private $start;
   private  $length;
   private $resId;
 private $userId;
   private $dateTime;
   private $mob;
   private $msg;
   private $created;
   private $modified;

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

    /**
     * @param mixed $resId
     */
    public function setResId($resId): void
    {
        $this->resId = $resId;
    }

    /**
     * @return mixed
     */
    public function getResId()
    {
        return $this->resId;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
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
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
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

    public function getReservation(){
        return DB::table('reservation AS r')->join('user AS u' , 'r.user_id','=' , 'u.user_id')->select('r.*' , 'u.name' , 'u.email')->paginate('5');
    }

    public function getReservationLimit(){
        return DB::table('reservation AS r')->join('user AS u' , 'r.user_id','=' , 'u.user_id')->select('r.*' , 'u.name' , 'u.email')->offset($this->start)->limit($this->length)->get();
    }

    public function countReservation(){
        return DB::table('reservation')->count('res_id');
    }
    public function getOneReservation(){
        return DB::table('reservation AS r')->join('user AS u' , 'r.user_id','=' , 'u.user_id')->where('res_id' , '=' , $this->resId)->select('r.*' , 'u.name' , 'u.email')->first();
    }

    public function addReservation(){
        DB::table('reservation')->insert([
              'date' => $this->dateTime , 'mobile' => $this->mob , 'message' => $this->msg , 'created' => $this->created , 'modified' => $this->modified , 'user_id' => $this->userId
        ]);
    }

    public function updateReservation(){
        DB::table('reservation')->where('res_id' , '=' , $this->resId)->update([
            'date' => $this->dateTime , 'mobile' => $this->mob , 'message' => $this->msg , 'modified' => $this->modified , 'user_id' => $this->userId
        ]);
    }

    public function deleteReservation(){
         DB::table('reservation')->where('res_id' , '=' , $this->resId)->delete();
    }

}
