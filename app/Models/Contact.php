<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class Contact
{
       private $name;
    private $email;
    private $subj;
    private $msg;
    private $created;
    private $modified;
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

       public function createContact(){
               DB::table('contact')->insert([
                           'name' => $this->name,
                            'email' => $this->email,
                             'subject' => $this->subj,
                               'message' => $this->msg ,
                                'created' => $this->created,
                                'modified' => $this->modified
               ]);
       }

}
