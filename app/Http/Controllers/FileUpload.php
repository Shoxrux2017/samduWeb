<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

class FileUpload extends Controller
{
    public function file_upload(Request $req){
   
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,png|max:10000'
        ]);

        $category = $req->input('category_file');
        $userId = $req->input('user_id');
      
    
    
        $fileModel = new File;
        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
     
            $title = $category;
            $fileModel->name = $req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->user_id = $userId;
            $fileModel->category_file = $title;
            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }

        return response([
            'message' => 'Upload success.'
        ], 200);

      
   }

   public function downloadFile(Request $request)
{
    $userId = $request->input('user_id');

    $category = $request->input('category_file');
   
    $file = DB::table('files')->where('user_id', $userId)->where('category_file', $category)->first();

    if ($file) {
        $filePath = $file->file_path;
        $fileName = $file->name;

        // $file = Storage::disk('public')->get($filePath);
        // $filePath = 'storage/app/public/uploads/qwerty.pdf';
      
        //  $filePath = Storage::path('public\\uploads\\');
        $localPath = storage_path('app/public') . str_replace('/storage', '', $filePath);
 
       
    //     $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

    // //       $headers = [
    // //     'Content-Type' => 'application/pdf',
    // //     'Content-Disposition' => 'attachment; filename="' . $file->name . '"',
    // // ];

    // return $localPath;
         return response()->download($localPath, $fileName);
    }

    // $path = storage_path('app/public' . str_replace('/storage', '', $file->file_path));
  

    // return response()->download($path, $file->name, $headers);

    // return response($file, 200)
    // ->header('Content-Type', 'application/octet-stream')
    // ->header('Content-Disposition', 'attachment; filename="' . $fileName . '.' . $fileExtension . '"');
    // }
    else{
        abort(404, 'File not found.');
    }
}

public function checkingFile(Request $request) {

    $category = $request->input('category_file');
    $userId = $request->input('user_id');


    $file = File::where('user_id', $userId)
                ->where('category_file', $category)
                ->first();
    // $files = DB::table('files')
    // ->where('user_id', $teacherId)
    // ->where('category_file', $category)
    // ->first();
  

    if ($file) {
        $file=[
            "id"=>'http://127.0.0.1:8000'.$file['file_path'],
            'message' => 'File exist.',    
           
        ];
        return response()->json($file, 200);

    } else {
        
        return response([
            'message' => 'File not found.'
        ], 404);
    
    }
}

public function deleteFile(Request $request) {

    $category = $request->input('category_file');
    $userId = $request->input('user_id');


    $file = File::where('user_id', $userId)
                ->where('category_file', $category)
                ->delete();
    // $files = DB::table('files')
    // ->where('user_id', $teacherId)
    // ->where('category_file', $category)
    // ->first();

    if ($file) {

       
        return response([
            'message' => "File deleted."
        ], 200);

    } else {
        
        return response([
            'message' => 'File did not deleted'
        ], 404);
    
    }
}


}
// time().'_'.