<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IlmiyIsh;
use App\Helpers\OrderHelper;

use Illuminate\Support\Facades\DB;


class IlmiyIshController extends Controller
{

   

    public function index(Request $req){
   
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,png|max:10000'
        ]);

        $title = $req->input('title');
        $publish = $req->input('publish');
        $year = $req->input('year');
        $page = $req->input('page');
        $author = $req->input('author');
        $coAuthor = $req->input('coAuthor');
        $authorCount = $req->input('authorCount');
        $doi = $req->input('doi');
        $scienceCategory = $req->input('scienceCategory');
        $publishType = $req->input('publishType');
        $publishLevel = $req->input('publishLevel');
        $publishLanguage = $req->input('publishLanguage');
        $studyYear = $req->input('studyYear');
        $userId = $req->input('userId');

    
    
        $ilmiyIshModel = new IlmiyIsh;
        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
     
            $ilmiyIshModel->title = $title;
            $ilmiyIshModel->file_path = '/storage/' . $filePath;
            $ilmiyIshModel->user_id = $userId;
            $ilmiyIshModel->publish = $publish;
            $ilmiyIshModel->year = $year;
            $ilmiyIshModel->page = $page;
            $ilmiyIshModel->author = $author;
            $ilmiyIshModel->coAuthor = $coAuthor;
            $ilmiyIshModel->authorCount = $authorCount;
            $ilmiyIshModel->doi = $doi;
            $ilmiyIshModel->science_category_title = $scienceCategory;
            $ilmiyIshModel->publish_type_title = $publishType;
            $ilmiyIshModel->publish_level_title = $publishLevel;
            $ilmiyIshModel->publish_language_title = $publishLanguage;
            $ilmiyIshModel->study_year_title = $studyYear;
            $ilmiyIshModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }

        return response([
            'message' => 'Upload success.'
        ], 200);


   
      
   }

   public function getIlmiyIsh(){

    $scienceWorks = IlmiyIsh::all();
 
    return response()->json($scienceWorks);
   }

   
   public function searchIlmiyIsh(Request $request){

    function smart_searchSorting($array, $search_term) {
      $ok = 0;
        // $result = array();
        foreach ($array as $value) {
            // Case-insensitive search
          if ($value == $search_term) {
              $ok = 1;  
              break;
            }
            else {
              $ok = 0;
             
            }
        }
        return $ok;
    }

    function smart_search($array, $search_term) {
      $ok = 0;
        // $result = array();
        $search_term = strtolower($search_term); 
        foreach ($array as $value) {
            $value_lower = strtolower($value); 
            // Case-insensitive search
    
            if (stripos($value, $search_term) !== false) {
              $ok = 1;  
              // $result[$key] = $value;
              break;
            }
            else {
              $ok = 0;
             
            }
        }
        return $ok;
    }

    $search = $request->input('search');
    $filter = $request->input('filter');
    $sorting = $request->input('sorting');

    if($search == null && $filter == null && $sorting == null){
      return response()->json("Ma'lumot topilmadi");
    }
    
    $array = IlmiyIsh::all();
 
   $scienceWorks = json_decode($array, true);
   
   


   $searchResult = [];   
    foreach(array_slice($scienceWorks, 0) as $scienceWork){


      $searchingFilterFields = [];
      $searchingFields = [];
      $searchingSortedFields = [];

      array_push($searchingSortedFields, $scienceWork['year']);
      array_push($searchingSortedFields, $scienceWork['page']);
      array_push($searchingSortedFields, $scienceWork['authorCount']);

     
      array_push($searchingFilterFields, $scienceWork['science_category_title']);
      array_push($searchingFilterFields, $scienceWork['publish_type_title']);
      array_push($searchingFilterFields, $scienceWork['publish_level_title']);
      array_push($searchingFilterFields, $scienceWork['publish_language_title']);
      array_push($searchingFilterFields, $scienceWork['study_year_title']);

      array_push($searchingFields, $scienceWork['title']);
      array_push($searchingFields, $scienceWork['publish']);
      array_push($searchingFields, $scienceWork['author']);
      array_push($searchingFields, $scienceWork['coAuthor']);


  
     
    // $valuesArray = array_values($scienceWork);
    $searchOk = 0;
    $searchFilterOk = 0;
    $searchSortingOk = 0;


    if($sorting != null){
    foreach ($sorting as $sort) {
      
      if ((smart_searchSorting($searchingSortedFields, $sort)) == 1) {
       
        $searchSortingOk = 1;
      } else {
       
        $searchSortingOk = 0;
        break;
      }

    }
   
  }
  

  
    if($filter != null){
    
     
      foreach ($filter as $fil) {
          
        if ((smart_search($searchingFilterFields, $fil)) == 1) {
          
          $searchFilterOk = 1;
        } else {
   
          $searchFilterOk = 0;
          break;
        }
      }
      
      
    }

  
   
  
    if($search != null){
      

        if ((smart_search($searchingFields, $search)) == 1) {
 
          $searchOk = 1;
        }

    }
    if($sorting == null){
      $searchSortingOk = 1;
    }
    if($search == null){
      $searchOk = 1;
    }
    if($filter == null){
      $searchFilterOk = 1;
    }
   
  

 
    if ( $searchOk == 1 && $searchFilterOk == 1 && $searchSortingOk == 1) {
    

      array_push($searchResult, $scienceWork);
    }


   
    }


      
    
          return response()->json($searchResult);
         
      
        
   }

  


  }

