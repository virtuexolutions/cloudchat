<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

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
        return view('home');
    }
    
    public function change_password()
    {
        return view('admin.changepassword');
    }


    public function store_change_password(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error', $validator->errors()->first());       
            }
            $user = Auth::user();

        if (!Hash::check($request->current_password,$user->password)) {
            return redirect()->back()->with('error', 'current password is Invalid');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password changed successfully !');

    }
}
