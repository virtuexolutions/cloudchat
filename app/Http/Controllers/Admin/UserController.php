<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use App\Models\DeviceLog;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Recording;

use Illuminate\Support\Facades\Storage;

use App\Models\media_file;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = Device::all();
        return view('admin.users.index',$data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		
        $device = Device::with(['deviceLog' => fn($query) => $query->where('status', '=', 1)])
		->where('id',$id)->first();
		//return $device;
        $data["device"] = $device;
	    return view('admin.users.view',$data);
    }
	public function Notifications($id)
    {
        $device = Device::with(['deviceLog' => fn($query) => $query->where('status', '=', 3)])
		->where('id',$id)->first();
        $data["device"] = $device;
	    return view('admin.users.notification',$data);
    }
	
	public function Contact($id)
    {
		$contact = Contact::where('device_id',$id)->first();		
        $data['contact'] = $contact;
		return view('admin.users.contacts',$data);
    }
	
	public function Gallery($id)
    {
		$gallery = Gallery::where('device_id',$id)->paginate(10);
		$data['gallery'] = $gallery;
        return view('admin.users.gallery',$data);
    }
	
	public function Screenshot($id)
    {
		$gallery = media_file::where('device_id',$id)->paginate(10);
		$data['screenshot'] = $gallery;
        return view('admin.users.screenshot',$data);
    }
	
	public function Recording($id)
    {
		$recording = Recording::where('device_id',$id)->paginate(10);
		$data['recording'] = $recording;
		return view('admin.users.audiorecordings',$data);
    }
	
	
	
	
	
	
	
	
	
	
	
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	
	public function destroy_audio(Request $request)
    {
		$checked = $request->checked;
	   foreach ($checked as $id) {
		   $device = Recording::where("id",$id)->first(); //Assuming you have a Todo model. 
		   $device->delete();
		   
	   }
	 
      
  		return redirect()->back()->with(['success'=>'Delete Successfully']);
    }
	
	public function destroy_gallery(Request $request)
    {
		$checked = $request->checked;
	   foreach ($checked as $id) {
		   $device = Gallery::where("id",$id)->first(); //Assuming you have a Todo model. 
		   $image = explode('/',$device->url);
		   public_path('/storage/gallery/' . $image[count($image)-1]);
		   if(file_exists(public_path('storage/gallery/' . $image[count($image)-1])))
		   {
			    unlink(public_path('storage/gallery/' . $image[count($image)-1]));
			   
		   }
		   else
		   {
		   		echo "nahi";

		   }
		   $device->delete();
		  	   
	   }
      
  		return redirect()->back()->with(['success'=>'Delete Successfully']);
    }
		
	public function destroy_media(Request $request)
    {
		//print_r(explode(url('/'),25));die;
        //
       //Device::where("id",$id)->delete(); 
       //DeviceLog::where("device_id",$id)->delete();
		//$request->checked;
	   $checked = $request->checked;
	   foreach ($checked as $id) {
		   $device = media_file::where("id",$id)->first(); //Assuming you have a Todo model. 
		   $image = explode('/',$device->url);
		   public_path('/storage/uploads/' . $image[count($image)-1]);
		   if(file_exists(public_path('storage/uploads/' . $image[count($image)-1])))
		   {
			    unlink(public_path('storage/uploads/' . $image[count($image)-1]));
			   
		   }
		   else
		   {
		   		echo "nahi";

		   }
		   $device->delete();
		  
		   //sprint_r($device->url);die;
		   
	   }
	   //Or as @Alex suggested 
//	   Todo::whereIn($checked)->delete();
      
  		return redirect()->back()->with(['success'=>'Delete Successfully']);
    }
	
    public function destroy($id)
    {
        //
       Device::where("id",$id)->delete(); 
       DeviceLog::where("device_id",$id)->delete();
      
       return redirect()->back()->with(['success'=>'Delete Successfully']);
    }
}
