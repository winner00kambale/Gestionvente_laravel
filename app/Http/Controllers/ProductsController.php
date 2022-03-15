<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $product = \DB::select("SELECT * FROM aff_products order by id DESC");
        $categ = \DB::select("SELECT * FROM categories order by id DESC");
        $fournisseur = \DB::select("SELECT * FROM fournisseurs order by id DESC");
        return view('products',compact('product','categ','fournisseur'));
    }
    public function store(Request $request){
        $request->validate([
            'designationP' => 'required',
            'nombreP' => 'required',
            'montantP' => 'required',
            'fournisseurP' => 'required',
        ]);
        \DB::statement("call sp_produit(?,?,?,?)",[
            $request->designationP,
            $request->nombreP,
            $request->montantP,
            $request->fournisseurP
        ]);
        return back()->with('message','insertion avec succes');
        //return redirect()->route('products.index')->with('message','insertion avec succes');
        // return response()->json(['message' => 'inserted succes']);   
    }
    
}
