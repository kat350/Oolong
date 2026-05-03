<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $tachesduJour = auth()->check()
            ? auth()->user()->taches()->whereDate('created_at', today())->take(4)->get()
            : collect();

        return view('welcome', ['tachesduJour' => $tachesduJour]);
    }
}
