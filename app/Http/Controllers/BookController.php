<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\FavouriteBooks;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:4'],
        ]);
        $file_cache = Cache::get('books');

        if (isset($file_cache)) {
            // return $file_cache;
            // return count($file_cache['result']['items']);
            $count=0;
            $foundItems = [];
            //  return $file_cache['result']['items'];
     
            foreach ($file_cache['result']['items'] as $item) {
                
                // return strpos(strtolower($item2['book_Title']) , strtolower($data['name']));
                if (str_contains( mb_strtolower($item['book_Title'], 'UTF-8'), mb_strtolower($data['name'], 'UTF-8'))) {
                   
                    $foundItems[]=[
                        "id"=>$item['id'],
                        "book_Title"=>$item['book_Title'],
                        "publisher"=>$item['publisher'],
                        "publish_Date"=>$item['publish_Date'],
                        "imageUrl"=>"https://e-libraryrest.samdu.uz/".$item['coverImage']['fileUrl'],
                       
                    ];
                    
                }
            }
            if (!empty($foundItems)) {
                return response()->json($foundItems, 200);
            }   
            
        }
        return response()->json(['error' => 'Kitob topilmadi'], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {      
        $token='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1laWQiOiIwOGRiZDIzNy1kM2FjLTQ0NzktOGNiOC1iM2U2Yjk2Y2UxY2YiLCJyb2xlIjoiVXNlciIsIm5iZiI6MTY5OTM0NjQ0OSwiZXhwIjoxNjk5NTE5MjQ5LCJpYXQiOjE2OTkzNDY0NDksImlzcyI6Imh0dHBzOi8vbG9jYWxob3N0OjUwMDMvIiwiYXVkIjoiaHR0cHM6Ly9sb2NhbGhvc3Q6NTAwMy8ifQ.htNzclci8wSts-mHrMAQgos5mxN0rai0Lysa33qT7d4';

        $data = $request->validate([
            'id' => ['required'], 
        ]);
    
       
        $b_id=$data['id'];
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token,])->timeout(5)->get("https://e-libraryrest.samdu.uz/api/Book/$b_id");
         
           if(!is_null($response['result'])){
           
                    // return $response['result']['publish_Date']; 
                    return response()->json(["book_URL"=>"https://e-libraryrest.samdu.uz/".$response['result']['book_File']['fileUrl'],
                    "id"=>$response['result']['id'],
                    "book_Title"=>$response['result']['book_Title'],
                    "book_Description"=>$response['result']['book_Description'],
                    "publisher"=>$response['result']['publisher'],
                    "publish_Date"=>$response['result']['publish_Date'],
                    "imageUrl"=>"https://e-libraryrest.samdu.uz/".$response['result']['coverImage']['fileUrl']], 200);
           }                                     
              
     
        return response()->json(['error' => 'Kitob topilmadi'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function isFavourite(Request $request)

    {   $token='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1laWQiOiIwOGRiZDIzNy1kM2FjLTQ0NzktOGNiOC1iM2U2Yjk2Y2UxY2YiLCJyb2xlIjoiVXNlciIsIm5iZiI6MTY5OTM0NjQ0OSwiZXhwIjoxNjk5NTE5MjQ5LCJpYXQiOjE2OTkzNDY0NDksImlzcyI6Imh0dHBzOi8vbG9jYWxob3N0OjUwMDMvIiwiYXVkIjoiaHR0cHM6Ly9sb2NhbGhvc3Q6NTAwMy8ifQ.htNzclci8wSts-mHrMAQgos5mxN0rai0Lysa33qT7d4';
        $data = $request->validate([
            'userId' => ['required'],
            'bookId' => ['required'], 
            'isFavourite' => ['required'],
        ]);

      

        if($data['isFavourite']){

            
        $favouriteBook = FavouriteBooks::where('user_id', $data['userId'])
        ->where('book_id', $data['bookId'])->first();
   
            if($favouriteBook){
                return response([
                    'message' => 'book already added.'
                ], 200);
            }

            $b_id=$data['bookId'];

                

        
          
            $favouriteBook = new FavouriteBooks;
       
        
            $favouriteBook->user_id = $data['userId'];            
            $favouriteBook->book_id = $response['result']['id'];
          
            $favouriteBook->book_title = $response['result']['book_Title'];
            $favouriteBook->image_url = "https://e-libraryrest.samdu.uz/".$response['result']['coverImage']['fileUrl'];
            $favouriteBook->publish_date = $response['result']['publish_Date'];
            $favouriteBook->publisher = $response['result']['publisher'];
            $favouriteBook->is_fav = $data['isFavourite'];
         
            $favouriteBook->save();

            return response([
                'message' => 'book is added.'
            ], 200);
        }else{

            $favouriteBook = FavouriteBooks::where('user_id', $data['userId'])
            ->where('book_id', $data['bookId'])
            ->delete();
    
            if ($favouriteBook) {
    
           
                return response([
                    'message' => "book is deleted."
                ], 200);
        
            } else {
                
                return response([
                    'message' => 'book did not deleted'
                ], 404);
            
            }
        }
       
      
        
       
    }

    public function getFavorite(Request $request){

        $data = $request->validate([
            'userId' => ['required'],
        ]);

        $kafedra = FavouriteBooks::where('user_id', $data['userId'])->get();

        if(count($kafedra)){
                  
            return $kafedra;
            
        }else{
            return response([
                'message' => 'Kitob topilmadi'
            ], 404);
        }
          
     
   
       

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


      
    }
    public function library(Request $request)
    {
        $data=$request->validate([
            'name' => ['required', 'min:5', 'regex:/^[A-Za-z ]+$/'],
        ]);
        $file_cache=Cache::get($data);
        if(isset($file_cache)){
            return is_string($file_cache) ? json_decode($file_cache) : $file_cache;
        }
        // $res = Books::where('book_name', $request->input('name'))->select('book_name', 'content')->get();

        // if ($res->isEmpty()) {
        //     return response()->json(['error' => 'Kitob topilmadi'], 404);
        // }

        // return response()->json($res, 200);
    }


    public function getBooks(Request $request)
    {
        ini_set('max_execution_time', 20);
        $books = Cache::remember('books', now()->addHours(168), function () {
        $allBooks = [];
        
        for ($pageNumber = 0; $pageNumber <2; $pageNumber++) {
            $response = Http::timeout(10)->get("https://e-libraryrest.samdu.uz/api/Book?pageNumber=$pageNumber&pageSize=200");
            
            if ($response->successful()) {
                $booksOnPage = $response->json();
                $allBooks = array_merge($allBooks, $booksOnPage['result']['items']);
            } else {
                // Xatolik yuz berdi, kerakli harakatlar bajarilishi mumkin
                return [];
            }
            }
        
            return ['result' => ['items' => $allBooks]];
        });

        
    }
}
