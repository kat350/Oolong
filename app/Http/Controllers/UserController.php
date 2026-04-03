<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $articles= Article::all();
        return view('dashboard',['articles' => $articles]);
    },
    public function add(Request $request) {
            $request->validate([
                'title'=>'required',
                'author'=>'required',
                'content'=>'required'
            ]);
            Article::create([
                'title'=>$request->title,
                'author'=>$request->author,
                'content'=>$request->content
            ]);
    },
    public function remove ($id) {
        Article::findOrFail($id)->delete();
        $articles= Article::all();
        return view('dashboard',['articles' => $articles]);
    }

}
