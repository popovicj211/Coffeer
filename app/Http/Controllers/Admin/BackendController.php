<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class BackendController extends Controller
{
    protected  $menu;
    protected $data;
    protected $thisDate;
    protected $perPage = 5;
    public function __construct()
    {
           $this->menu = new Menu();
           $this->data['menus'] = $this->menu->getAllMenu();
        $this->thisDate = date("Y-m-d H:i:s");
    }
}
