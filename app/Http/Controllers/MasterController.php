<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index(){
        $alert = \DB::select("SELECT id,article,quantite FROM stock WHERE quantite <=(SELECT nombre FROM alertstock)");
        return view('dashbord',compact('alert'));
        }
}
