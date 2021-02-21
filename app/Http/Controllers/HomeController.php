<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() 
    {
        $user=Auth::user();

        // dd('hi');
        // if($user->type==1 && $user->status==1)
        // {
            return view('dashboard');
        // }
        // else
        // {
        //     return view('restriction');
        // }
    }
}
