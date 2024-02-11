<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    public function showAll(Request $request)
    {   
        $publicKey = env('MARVEL_PUBLIC_KEY');
        $privateKey = env('MARVEL_PRIVATE_KEY');
        $ts = time();
        $hash = md5($ts.$privateKey.$publicKey);

        //Pagination
        // Below we are using the query method to get the page and limit parameters from the request.
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 20);
        $searchQuery = $request->query('search', '');

        $queryParams = [
          'apikey' => $publicKey,
          'ts' => $ts,
          'hash' => $hash,
          'offset' => ($page - 1) * $limit,
          'limit' => $limit
         ];
      
        if (!empty($searchQuery)) {
            $queryParams['nameStartsWith'] = $searchQuery; // Adjust according to the Marvel API documentation
        }
    
        $response = Http::get("https://gateway.marvel.com:443/v1/public/characters", $queryParams);
        
        // We are using the json method to convert the response to an array.
        $data = $response->json();

        // We are returning a JSON response with the data, total number of characters, limit and page.
        return response()->json([
          'data' => $data['data']['results'], // Actual data
          'total' => $data['data']['total'], // Total number of characters
          'limit' => $limit,
          'page' => $page,
      ]);
    }

    public function showId($id){
      $publicKey = env('MARVEL_PUBLIC_KEY');
      $privateKey = env('MARVEL_PRIVATE_KEY');
      $ts = time();
      $hash = md5($ts.$privateKey.$publicKey);
  
      $response = Http::get("https://gateway.marvel.com:443/v1/public/characters/{$id}", [
          'apikey' => $publicKey,
          'ts' => $ts,
          'hash' => $hash,
      ]);
  
      return response()->json($response->json());
    }
}