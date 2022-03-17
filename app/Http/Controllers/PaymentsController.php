<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facture;
use App\Models\Caisse;

class PaymentsController extends Controller
{
    public function index(){
        $facture = Facture::all();
        $caisse = Caisse::all();
        $payment = \DB::select("SELECT * FROM `payments` ORDER BY id DESC");
        return view('payments',compact('facture','caisse','payment'));
    }
    public function store(Request $request){
        $request->validate([
            'nom' => 'required',
            'facture' => 'required',
            'montant' => 'required',
            'libelle' => 'required',
        ]);
        try {
            \DB::statement("call sp_payment(?,?,?,?)",[
                $request->facture,
                $request->nom,
                $request->montant,
                $request->libelle
            ]);
            return back()->with('message','payment succes');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return back()->with('error', 'Cette facture a deja ete payee !');
             }
            else{
             return back()->with('error', 'Cette facture a deja ete payee !');
            }
        }
           
    }
}
