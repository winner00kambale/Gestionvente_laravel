<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class MasterController extends Controller
{
    public function index(){
        $user_id = Auth::user()->email;
        $alert = \DB::select("SELECT id,article,quantite FROM stock WHERE quantite <=(SELECT nombre FROM alertstock)");
        $nombre_achat= \DB::select("SELECT COUNT(*)nbr,CURDATE() date FROM `products_sale` WHERE products_sale.dates=CURDATE()");
        $nbrclient= \DB::select("SELECT COUNT(*)nbrclient,CURDATE() date FROM `clients`");
        $nbrfournisseur= \DB::select("SELECT COUNT(*)nbrfour,CURDATE() date FROM fournisseurs");
        return view('dashbord',compact('alert','nombre_achat','nbrclient','nbrfournisseur'));
        }
}
