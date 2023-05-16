<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Twilio\Rest\Client;
use Exception;


class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return response()->json(['success'=>false,'message'=>$validator->errors()->first()],500);    
        }
   
        $input = $request->except(['_token','c_password'],$request->all());
        if(isset($input)){
            $input['password'] = Hash::make($request['password']);
            $input['verifycode'] = rand(1000,9999);
            if($request->image)
            {
                $files = $request->file('image');
                $destinationPath = public_path('/uploads/users/'); // upload path
                $fileName = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $fileName);
                $input['image'] = asset('/uploads/users/'.$fileName);
            }       
            $user = User::create($input);
            $this->sendmessage($request->phone,$input['verifycode']);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user_details'] =  $user;
            
        }
        return $this->sendResponse($success, 'User register successfully.');
    }   
    private function sendmessage($receiverNumber,$code)
    {
        $message = "Your Authentication Code is ". $code;
        try 
        {
            $account_sid = "AC68491feb9a17cea3c9c2ea196495528e";
            $auth_token = "7eb9e29f3c550a56d52edd165c4de5d0";
            $twilio_number = "+16073897408";
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
            return response()->json(['SMS Sent Successfully.'], 200);
  
        } 
        catch (Exception $e)
        {
            return response()->json([$e->getMessage()], 200);
        }
    }
    public function login(Request $request)
    {
        if(!empty($request->all()))
        {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
            ]);
            if ($validator->fails()) 
            {    
                return $this->sendError('Unauthorised.', ['error'=> $validator->errors()]);
            }    
            
            if(Auth::attempt(['phone' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $user["_id"] = Auth::id();
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                $success['user_info'] =  $user;
                
                return $this->sendResponse($success, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('Password is Incorrect.', ['error'=> 'Password is Incorrect']);
            } 
        }
        else
        { 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
    
    public function adminlogin(Request $request)
    {
            return view('auth.login');
    }
}
