<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'designation' => 'required',
        ]);
        \DB::table('categories')->insert([
            'designation' => $request->designation
        ]);
        return response()->json(['message' => 'inserted succes']);   
    }
}
