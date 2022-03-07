<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FournisseursController extends Controller
{
    public function index(){
        $fournisseur = \DB::select("SELECT * FROM fournisseurs order by id DESC");
        return view('fournisseurs',compact('fournisseur'));
    }
    public function store(Request $request){
        $request->validate([
            'nom' => 'required',
            'postnom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'adresse' => 'required',
            'shop' => 'required',
            'telephone' => 'required',
        ]);
        \DB::table('fournisseurs')->insert([
            'nom' => $request->nom,
            'postnom' => $request->postnom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'adresse' => $request->adresse,
            'shop' => $request->shop,
            'telephone' => $request->telephone
        ]);
        return response()->json(['message' => 'inserted succes']);   
    }

    public function update(Request $request){
        \DB::update('UPDATE fournisseurs set nom = ?, postnom = ?, prenom= ?, sexe= ?, adresse= ?,shop= ?, telephone = ? where id = ?',[$request->nom, $request->postnom, $request->prenom, $request->sexe, $request->adresse, $request->shop, $request->telephone, $request->id]);
        return redirect()->route('fournisseur.index');
    }
}
