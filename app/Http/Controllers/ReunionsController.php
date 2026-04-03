<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;

class ReunionsController extends Controller
{   
    public function all_articles() {
    $reunions =reunions::all();
    return view('reunion', [
        "reunions"=> $reunions,
        "nom"=>"Blogito"
    ]);
},
    public function reunionById($id) {
    $reunions = Article::where('id', $id)->first();
    return view('reunion', ['reunion'=> $reunion]);
}

}
