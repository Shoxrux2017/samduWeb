<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Storage;
use App\Models\File;


use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
class TeacherController extends Controller
{
    public function index($kafedra_id)
    {

        
        $teacher = User::whereHas('kafedra', function ($query) use ($kafedra_id) {
            $query->where('kafedra_id', $kafedra_id);
        })->get();

        if(!$teacher)
        {
            return response([
                'message' => 'Teacher not found.'
            ], 403);
        }
        return response([
            'teacher' => $teacher
        ], 200);

        dd($teacher);
        // return response(['kafedra' => Kafedra::all()], 200);
    }

    public function saveAvatarImg(Request $request, User $user){
        // Validate the uploaded file
    $request->validate([
        'file   ' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $fileName = $request->file->getClientOriginalName();
    $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');


    // Store the uploaded image in the storage directory
    // $path = $request->file('image')->store('public/images');

    // Update the user's image path in the database
    $user->image = '/storage/' . $filePath;
    $user->save();

    return redirect()->back()->with('success', 'Image uploaded successfully!');
    }
}

  

