<?php

namespace App\Http\Controllers;

use App\Models\OquvUslubiyIshModel;
use Illuminate\Http\Request;

class OquvUslubiyIshConroller extends Controller
{
    public function index(Request $req){
   
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,png|max:10000'
        ]);

        $userId = $req->input('userId');
        $uslubiyNashrTuri = $req->input('uslubiyNashrTuri');
        $uslubiyNashrTili = $req->input('uslubiyNashrTili');
        $uslubiyNashrNomi = $req->input('uslubiyNashrNomi');
        $mualliflar = $req->input('mualliflar');
        $mualliflarSoni = $req->input('mualliflarSoni');     
        $nashriyot = $req->input('nashriyot');
        $nashrParametrlari = $req->input('nashrParametrlari');
        $nashrYili = $req->input('uslubiyNashrYili');
        $guvohnomaRaqami = $req->input('guvohnomaRaqami');
        $guvohnomaSanasi = $req->input('guvohnomaSanasi');
        $oquvYili = $req->input('uslubiyNashrOquvYili');


    
    
        $oquvUslubiyIshModel = new OquvUslubiyIshModel;
        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
     
            $oquvUslubiyIshModel->user_id = (int)$userId;
            $oquvUslubiyIshModel->file_path = '/storage/' . $filePath;
            $oquvUslubiyIshModel->uslubiy_nashr_turi = $uslubiyNashrTuri;
            $oquvUslubiyIshModel->uslubiy_nashr_tili = $uslubiyNashrTili;
            $oquvUslubiyIshModel->uslubiy_nashr_nomi = $uslubiyNashrNomi;
            $oquvUslubiyIshModel->mualliflar_soni = $mualliflarSoni;
            $oquvUslubiyIshModel->mualliflar = $mualliflar;
            $oquvUslubiyIshModel->nashriyot = $nashriyot;
            $oquvUslubiyIshModel->nashr_parametrlari = $nashrParametrlari;
            $oquvUslubiyIshModel->nashr_yili = $nashrYili;
            $oquvUslubiyIshModel->guvohnoma_raqami = $guvohnomaRaqami;
            $oquvUslubiyIshModel->guvohnoma_sanasi = $guvohnomaSanasi;
            $oquvUslubiyIshModel->oquv_yili = $oquvYili;
            $oquvUslubiyIshModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }

        return response([
            'message' => 'Upload success.'
        ], 200);


   
      
   }

   public function getOquvUslubiyIsh(){

    $oquvuslubiyIsh = OquvUslubiyIshModel::all();
 
    return response()->json($oquvuslubiyIsh);
   }

   
   public function searchOquvUslubiyIsh(Request $request){

    // function smart_searchSorting($array, $search_term) {
    //   $ok = 0;
    //     // $result = array();
    //     foreach ($array as $value) {
    //         // Case-insensitive search
    //       if ($value == $search_term) {
    //           $ok = 1;  
    //           break;
    //         }
    //         else {
    //           $ok = 0;
             
    //         }
    //     }
    //     return $ok;
    // }

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


    if($search == null && $filter == null){
      return response()->json("Ma'lumot topilmadi");
    }
    
    $array = OquvUslubiyIshModel::all();
 
   $scienceWorks = json_decode($array, true);
   
   


   $searchResult = [];   
    foreach(array_slice($scienceWorks, 0) as $scienceWork){


      

      $searchingFilterFields = [];
      $searchingFields = [];
    
      array_push($searchingFilterFields, $scienceWork['uslubiy_nashr_turi']);
      array_push($searchingFilterFields, $scienceWork['uslubiy_nashr_tili']);
      array_push($searchingFilterFields, $scienceWork['nashr_yili']);
      array_push($searchingFilterFields, $scienceWork['guvohnoma_sanasi']);
      array_push($searchingFilterFields, $scienceWork['oquv_yili']);

      array_push($searchingFields, $scienceWork['uslubiy_nashr_nomi']);
      array_push($searchingFields, $scienceWork['mualliflar']);
      array_push($searchingFields, $scienceWork['nashriyot']);

    

  
     
    // $valuesArray = array_values($scienceWork);
    $searchOk = 0;
    $searchFilterOk = 0; 

   
    if($search != null){
      
      if ((smart_search($searchingFields, $search)) == 1) {
        $searchOk = 1;
  
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
   
  


    if($search == null){
      $searchOk = 1;
    }
    if($filter == null){
      $searchFilterOk = 1;
    } 

  

    if ( $searchOk == 1 && $searchFilterOk == 1) {
    

      array_push($searchResult, $scienceWork);
    }


   
    }

    
          return response()->json($searchResult);
         
        
   }

  

}
