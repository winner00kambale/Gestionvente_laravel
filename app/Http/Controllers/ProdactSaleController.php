<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdactSaleController extends Controller
{
    public function index(){
        $sale = \DB::select("SELECT * FROM aff_vente order by id DESC");
        $stock = \DB::select("SELECT * FROM stock order by id DESC");
        $panier = \DB::select("SELECT * FROM panier order by id DESC");
        $client = \DB::select("SELECT * FROM clients order by id ASC");
        $prod = \DB::select("SELECT * FROM categories order by id DESC");
        return view('sale',compact('sale','stock','panier','client','prod'));
    }
    public function store(Request $request){
        $request->validate([
            'client' => 'required',
            'designation' => 'required',
            'nombre' => 'required',
            'montant' => 'required',
        ]);
        try {
            \DB::statement("call sp_vente(?,?,?,?)",[
                $request->client,
                $request->designation,
                $request->nombre,
                $request->montant
            ]);
            return back()->with('message','insertion avec succes');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return back()->with('error', 'erreur');
             }
            else{
             return back()->with('error', 'Impossible de passer cette operation. Veillez approvisionner svp !');
            }
        }           
    }
    public function store_fac(){
        \DB::statement("call sp_facture()");
        return back()->with('message','Facture enregistree');       
    }
}
