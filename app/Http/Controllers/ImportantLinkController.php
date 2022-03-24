<?php


namespace App\Http\Controllers;

use App\Models\ImportantLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator ;

class ImportantLinkController extends Controller
{
    function getAllLinks(){
        $allLinks = ImportantLink ::get();  
        return response($allLinks , 200 );
    }

    function getOneLink($id){
        $link = ImportantLink ::find($id); 
        if($link){
            return response($link , 200 );
        } 
        $error = [
            'data'=>null,
            'message'=>"No Link with id".$id,
        ];
        return response($error , 401 );
    }

    function addLink(Request $request){
        $validator =Validator::make($request->all(),[
            'logo_url' => 'required',
            'website_link' => 'required',
            'title' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $link = ImportantLink ::create([
            'logo_url' => $request->logo_url,
            'website_link' => $request->website_link,
            'title' => $request->title,
            ]);
        return response($link , 200 );
    }
    function updateLink(Request $request ,$id ){
        $validator =Validator::make($request->all(),[
            'logo_url' => 'required',
            'website_link' => 'required',
            'title' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        ImportantLink::where("id", $id)->update([
            'title'=>$request->title,
            'website_link'=>$request->website_link,
            'logo_url'=>$request->logo_url,
        ])  ;
        $link = ImportantLink ::find($id);
        return response($link , 200 );
    }

    function deleteLink ($id){
        $link = ImportantLink ::find($id); 
        if($link){
            $deleted = ImportantLink::where('id', $id)->delete();
        return response([
            'msg'=>$deleted.' deleted successfully'
            ] , 200 );
        } 
        $error = [
            'data'=>null,
            'message'=>"No Link with id".$id,
        ];
      
        return response($error, 400 );
    }
}
