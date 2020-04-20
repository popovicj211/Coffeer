<?php


namespace App\Models;
use Illuminate\Support\Facades\DB;

class Role
{
    public function getRole()
    {
        return DB::table('role')->get();
    }


}
