<?php


namespace App\Http\Controllers;

use App\Models\Divices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DevicesController extends Controller
{

    function getViewsCount (){
        $views = Divices::get();
        $count = count($views);
        return response(['count'=>$count],200);
    }

    function makeView(Request $request){

        $validator = Validator::make($request->all(), [
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $id = $request->device_id;
       
        $devices =  Divices::where('device_id', $id)->get();


       if (count($devices)==0){
        $device = Divices::create([
            'device_id' => $id
        ]);
        return response($device,200);
    }
    return response(['msg'=> 'this device exist before '],400);
    }

}
