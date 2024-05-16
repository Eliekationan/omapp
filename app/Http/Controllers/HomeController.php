<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\SCD;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('layouts.app');
    }
    public function dashboard(Request $request){
        $users = User::where('id',Auth::user()->id)->with('roles')->first();
        return response()->json($users, 200);
    }

    public function deconnexion(Request $request)
    {
        Session::flush();

        Auth::logout();
        try {
            $user = $request->user();
            $user->tokens()->delete();
            $this->guard()->logout();
            auth()->logout();
            $request->session()->flush();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect('login');
    }

    public function loadData(Request $request){
        SCD::loadData();
    }
}
