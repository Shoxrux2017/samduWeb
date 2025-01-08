<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FileUpload;
use App\Http\Controllers\FakultetController;
use App\Http\Controllers\KafedraController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\IlmiyIshController;
use App\Http\Controllers\IlmiyIshDetailsController;
use App\Http\Controllers\OquvUslubiyIshConroller;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {

    // User
    Route::get('/user/{id}', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Post
    Route::get('/posts', [PostController::class, 'index']); // all posts
    Route::post('/posts', [PostController::class, 'store']); // create post
    Route::get('/posts/{id}', [PostController::class, 'show']); // get single post
    Route::put('/posts/{id}', [PostController::class, 'update']); // update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

    // Comment
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

    // Like
    Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike']); // like or dislike back a post

    Route::post('/upload-file', [FileUpload::class, 'file_upload'])->name('fileUpload');
    Route::get('/downloadFile', [FileUpload::class, 'downloadFile'])->name('downloadFile');
    Route::get('/checkingFile', [FileUpload::class, 'checkingFile'])->name('checkingFile');
    Route::get('/deleteFile', [FileUpload::class, 'deleteFile'])->name('deleteFile');

   

    Route::get('/fakultet', [FakultetController::class, 'index']);
    Route::get('/kafedra/{fakultet_id}', KafedraController::class);
    Route::get('/teacher/{kafedra_id}', [TeacherController::class, 'index']);
    Route::post('/saveAvatarImg/{user}', [TeacherController::class, 'saveAvatarImg'])->name('sai');


    Route::resource("users-library", BookController::class);
    Route::get("/isFavourite", [BookController::class, 'isFavourite'])->name('isFavourite');
    Route::get("/getFavorite", [BookController::class, 'getFavorite'])->name('getFavorite');

   

    Route::get('/science-category', [IlmiyIshDetailsController::class, 'scienceCategory']); 
    Route::get('/publish-type', [IlmiyIshDetailsController::class, 'publishType']); 
    Route::get('/publish-level', [IlmiyIshDetailsController::class, 'publishLevel']); 

    Route::get('/nashrTili', [IlmiyIshDetailsController::class, 'nashrTili']);

    Route::get('/uslubiyNashTuri', [IlmiyIshDetailsController::class, 'uslubiyNashTuri']);

    Route::get('/nashrYili', [IlmiyIshDetailsController::class, 'nashrYili']); 
    Route::get('/oquvYili', [IlmiyIshDetailsController::class, 'oquvYili']); 


    Route::post('/ilmiy-ish', [IlmiyIshController::class, 'index']);
    Route::get('ilmiyIsh', [IlmiyIshController::class, 'getIlmiyIsh']);
    Route::post('/searchIlmiyIsh', [IlmiyIshController::class, 'searchIlmiyIsh']);

    Route::post('/oquvUslubiyIsh', [OquvUslubiyIshConroller::class, 'index']);
    Route::get('uslubiyIsh', [OquvUslubiyIshConroller::class, 'getOquvUslubiyIsh']);
    Route::post('/searchOquvUslubiyIsh', [OquvUslubiyIshConroller::class, 'searchOquvUslubiyIsh']);
   
  
});