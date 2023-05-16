<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use Auth;
use DB;
use App\Events\PusherEvent;
class ChatConroller extends Controller
{
    //
    public function GetChats()
    {
       $data =  Chat::with(["ChatUser","ChatTargetUser"])
       ->select([
            "*",
            "id as _id",
            DB::Raw("(select message from  chat_rooms where chat_id = chats.id order by id desc limit 1) as  LastMessage"),
		    DB::Raw("(select count(*) from  chat_rooms where chat_id = chats.id) as  unread"),
		])
        ->with(['ChatUser' => function ($query) {
            $query->select(['*','id as _id']);
        }])
        ->with(['ChatTargetUser' => function ($query) {
            $query->select(['*','id as _id']);
        }])
       ->orwhere("user_id",Auth::id())
       ->orwhere("target_id",Auth::id())
       ->get();
       return response()->json($data, 200);
    }
    public function ChatDetail($id)
    {
        $data =  Chat::with(["ChatUser","ChatTargetUser","ChatRoom"])
        ->where("id",$id)->first();
		$data["ChatRoom"] = $data->ChatRoom->pluck("message");
		ChatRoom::where("id",$id)->where("to_user_id",Auth::id())->update(["status" => 0]);
		return response()->json($data, 200);
    }
    public function messageSent(request $request)
    {  
        $target_user = user::find($request->target_id);
        $resp = ChatRoom::Create([
            "chat_id" => $request->chat_id,
            "from_user_id" => Auth::id(),
            "message" => json_encode(array(
					"text" => $request->text,
					"createdAt" => date('Y-m-d'),
					"user" => array(
						"_id" => auth::id(),
						"name" =>  auth::user()->first_name,
						"avatar" => auth::user()->image
					),
			)),
            "to_user_id" => $request->target_id
        ]);
        $formated_resp = array(
            "text" => $request->text,
            "createdAt" => $resp->created_at,
            "user" => array(
                "_id" => auth::id(),
                "name" =>  auth::user()->first_name,
                "avatar" => auth::user()->image
            ),
        );
        event(new PusherEvent($request->text,$request->chat_id,$request->target_id,$formated_resp));
    }
    

}
