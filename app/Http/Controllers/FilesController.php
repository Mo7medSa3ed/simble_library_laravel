<?php


namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{
  function get (

  ){}
    function getAllFiles()
    {
        $allFiles = Files::get();
        return response($allFiles, 200);
    }

    function getOneFileByYearAndRelateTo($relate_to ,$year)
    {
        $allFiles= Files::where('relate_to', $relate_to)-> where('year', $year)-> get();
        return response($allFiles, 200);
    }

    function getOneFile($id)
    {
        $file = Files::find($id);
        if ($file) {
            return response($file, 200);
        }
        $error = [
            'data' => null,
            'message' => "No File with id " . $id,
        ];
        return response($error, 401);
    }

    function addFile(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file->storeAs('public', $file_name);
            $file_url = URL::asset('storage/' . $file_name);


            $file = Files::create([
                'file_url' => $file_url,
                'title' => $request->title,
                'file_name' => $file_name,
                'relate_to' => $request->relate_to,
                'year' => $request->year,
            ]);
            return response($file, 200);
        }
        return response(["msg" => "file not valid"], 400);
    }

    function updateFile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'relate_to' => 'required',
            'year' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $file = Files::find($id);
        if ($file) {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {

                unlink(storage_path('app/public/' . $file->file_name));
                $file = $request->file('file');
                $file_name = $file->getClientOriginalName();
                $file->storeAs('public', $file_name);
                $file_url = URL::asset('storage/' . $file_name);

                Files::where("id", $id)->update([
                    'file_url' => $file_url,
                    'title' => $request->title,
                    'file_name' => $file_name,
                    'relate_to' => $request->relate_to,
                    'year' => $request->year,
                ]);
            } else {

                Files::where("id", $id)->update([
                    'title' => $request->title,
                    'relate_to' => $request->relate_to,
                    'year' => $request->year,
                ]);
            }
            $updated_file = Files::find($id);
            return response($updated_file, 200);
        }
        $error = [
            'data' => null,
            'message' => "No File with id " . $id,
        ];

        return response($error, 400);
    }

    function deleteFile($id)
    {

        $file = Files::find($id);
        if ($file) {
            $deleted = Files::where('id', $id)->delete();
            unlink(storage_path('app/public/' . $file->file_name));
            return response([
                'msg' => $deleted . ' deleted successfully'
            ], 200);
        }
        $error = [
            'data' => null,
            'message' => "No File with id " . $id,
        ];

        return response($error, 400);
    }
}
