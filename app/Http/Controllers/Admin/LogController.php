<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLogs($id = 1){
         $perPage = 21;
          $file = file(storage_path('logs/ip_admincritical.log'));
          $filePages = file(storage_path('logs/ip_critical.log'));
         $first_ips = ($id - 1) * $perPage;
         $last_ips = $id * $perPage - 1;

         $this->data['fileAdm'] = $file;
          $this->data['filePages'] = $filePages;
          $this->data['first_ips'] = $first_ips;
          $this->data['last_ips'] = $last_ips;
          $this->data['per_page'] = $perPage;

          return view('pages.admin.log' ,$this->data );

     }

     public function deleteLogs(){



     }


}
