<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlertStockController extends Controller
{
    public function index(){
        $stockAlerte = \DB::select("SELECT * FROM alertstock order by id DESC");
        return view('parametter',compact('stockAlerte'));
    }
    public function store(Request $request){
        $request->validate([
            'nombre_sec' => 'required',
        ]);
        \DB::statement("call st_securite(?)",[
            $request->nombre_sec
        ]);
        return back()->with('message','Insertion avec succes');   
    }
}
