<?php


namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;

class ContactAdmin
{
      private $start;
      private $length;
      private $cont;

      private $name;
      private $email;
      private $subj;
      private $message;
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
     * @param mixed $cont
     */
    public function setCont($cont): void
    {
        $this->cont = $cont;
    }

    /**
     * @return mixed
     */
    public function getCont()
    {
        return $this->cont;
    }

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
     * @param mixed $subj
     */
    public function setSubj($subj): void
    {
        $this->subj = $subj;
    }

    /**
     * @return mixed
     */
    public function getSubj()
    {
        return $this->subj;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
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



     public function getContact(){
         return DB::table('contact')->paginate(5);
     }

     public function getContactLimit(){
         return DB::table('contact')->offset($this->start)->limit($this->length)->get();
     }

     public function countContact(){
        return DB::table('contact')->count('cont_id');
     }

     public function getOneContact(){
        return DB::table('contact')->where('cont_id' , '=' , $this->cont )->first();
     }

     public function addContact(){
         DB::table('contact')->insert([
              'name' => $this->name , 'email' => $this->email , 'subject' => $this->subj , 'message' => $this->message
         ]);
     }

     public function updateContact(){
         DB::table('contact')->where('cont_id' , '=' , $this->cont)->update([
             'name' => $this->name , 'email' => $this->email , 'subject' => $this->subj , 'message' => $this->message
         ]);
     }

     public function deleteContact(){
         DB::table('contact')->where('cont_id' , '=' , $this->cont)->delete();
     }

    public function getAllContacts(){
        return DB::table('contact')->select('cont_id' ,'name' , 'email')->get();
    }

}
