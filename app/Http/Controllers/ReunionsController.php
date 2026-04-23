<?php

namespace App\Http\Controllers;
use App\Models\Reunion;
use Illuminate\Http\Request;

class ReunionsController extends Controller
{   
    public function all() {
    $reunions = Reunion::all();
    return view('reunion', ["reunions" => $reunions]);
}

    public function reunionById($id) {
    $reunion = Reunion::where('id', $id)->first();
    return view('reunion', ['reunion' => $reunion]);
}

}

