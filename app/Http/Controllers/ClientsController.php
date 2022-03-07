<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(){
        $client = \DB::select("SELECT * FROM clients order by id DESC");
        return view('client',compact('client'));
    }
    public function store(Request $request){
        $request->validate([
            'nom' => 'required',
            'postnom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'quartier' => 'required',
            'avenue' => 'required',
            'telephone' => 'required',
        ]);
        \DB::table('clients')->insert([
            'nom' => $request->nom,
            'postnom' => $request->postnom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'quartier' => $request->quartier,
            'avenue' => $request->avenue,
            'telephone' => $request->telephone
        ]);
        return response()->json(['message' => 'inserted succes']);   
    }
    public function update(Request $request){
        \DB::update('UPDATE clients set nom = ?, postnom = ?, prenom= ?, sexe= ? ,quartier= ? ,avenue= ?, telephone = ? where id = ?',[$request->nom, $request->postnom, $request->prenom, $request->sexe, $request->quartier, $request->avenue, $request->telephone, $request->id]);
        return redirect()->route('client.index');
    }
}
