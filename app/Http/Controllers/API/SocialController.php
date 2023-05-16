<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Social;
use App\Models\Chat;
use App\Models\ChatRoom;
use DB;
use Auth;

class SocialController extends Controller
{
    //
    public function  get_all_Users()
    {
        $data = User::where("id","!=",Auth::id())
        ->select(["*",DB::Raw("(select count(*) as request from socials where target_id = users.id AND confirmed = 0) as request_sent")])
        ->get();

        return response()->json($data, 200);
    }
    public function  Search_User(request $request)
    {
        return response()->json(User::where("id","!=",Auth::id())->get(), 200);
    }
    public function  get_friends()
    {
        $data  = Social::with("RequestUserDetail")
        ->orWhere("user_id",Auth::id())
        ->orWhere("target_id",Auth::id())
        ->where("confirmed",true)
        ->get();
        return response()->json($data, 200);
    }
    public function  get_Requests()
    {
        $data  = Social::with("RequestUserDetail")
        ->where("target_id",Auth::id())
        ->where("confirmed",false)
        ->get();
        return response()->json($data, 200);
    }
    public function  friend_Request(request $request)
    {
        $data  = Social::create([
            "user_id" => Auth::id(),
            "target_id" => $request->target_id,
            "confirmed" => false 
        ]);
        return response()->json(["success" => true , "message" => "Request Send Successfull"], 200);
    }
    public function  Cancel_Request(request $request)
    {
        $data  = Social::where([
            ["user_id",'=', Auth::id()],
            ["target_id",'=', $request->target_id],
            ["confirmed",'=', false]
        ])->delete();
        
        return response()->json(["success" => true , "message" => "Request Cancel Successfull"], 200);
    }
    public function  Denied_Request(request $request)
    {
        $data  = Social::where([
            ["target_id",'=', Auth::id()],
            ["user_id",'=', $request->target_id],
            ["confirmed",'=', false]
        ])->delete();
        return response()->json(["success" => true , "message" => "Request Denied Successfull"], 200);
    }
    public function  confirm_Request(request $request)
    {
        $data  = Social::where([
            ["target_id",'=', Auth::id()],
            ["user_id",'=', $request->target_id],
            ["confirmed",'=', false]
        ])->update(["confirmed" => true]);
        $this->crate_chat_room($request->target_id);
        return response()->json(["success" => true , "message" => "Request Accepted Successfull"], 200);
    }
    private function  crate_chat_room($target_id)
    {
         $resp = Chat::create([
            "user_id" => auth::id(),
            "target_id" => $target_id,
            "status" => 1,
         ]);
         return $resp;
    }
    

} 
