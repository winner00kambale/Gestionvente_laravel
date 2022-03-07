<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdactSaleController extends Controller
{
    public function index(){
        $sale = \DB::select("SELECT * FROM products_sale order by id DESC");
        $stock = \DB::select("SELECT * FROM stock order by id DESC");
        $panier = \DB::select("SELECT * FROM panier order by id DESC");
        $client = \DB::select("SELECT * FROM clients order by id DESC");
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
        \DB::statement("call sp_vente(?,?,?,?)",[
            $request->client,
            $request->designation,
            $request->nombre,
            $request->montant
        ]);
        return back()->with('message','insertion avec succes');
        //return redirect()->route('products.index')->with('message','insertion avec succes');
        // return response()->json(['message' => 'inserted succes']);   
    }
}
