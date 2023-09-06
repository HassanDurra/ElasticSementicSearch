<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elastic\Elasticsearch\ClientBuilder;
class HadithController extends Controller
{

public function searchView()
{
    return view('search');
}

public function searchSahiBukhari(Request $request)
{
    $query = $request->input('query');

    $client = ClientBuilder::create()
        ->setElasticCloudId('HadithSementicSearch:dXMtY2VudHJhbDEuZ2NwLmNsb3VkLmVzLmlvJGRlNWNjZTU4MTYwMzQ5YTVhZGJmYzgyYTQwZTkyY2VjJDBlYTUzNDNjY2ViZTRhNmRhYbZmMzIwN2UzN2EwYjYw')
        ->setBasicAuthentication('elastic', '0ycqOf5MDcYSrVJscgk0qbtA')
        ->build();

    // Elasticsearch index name and type
    $index_name = "search-sahibukhari";

    $params = [
        'index' => $index_name,
        'body' => [
            'query' => [
                'match' => [
                    'text' => $query, // Field to search for similarity
                ],
            ],
        ],
    ];

    try {
        $response = $client->search($params);

        // Extract specific fields from the Elasticsearch results
        $firstHit = $response['hits']['hits'][0]['_source'];
         // Define the specific fields to include in the response
         $result = [
            'hadithnumber' => $firstHit['hadithnumber'],
            'text' => $firstHit['text'],
            'book' => $firstHit['reference']['book'],
            'hadith' => $firstHit['reference']['hadith'],
        ];

        // Return the extracted fields
        return response()->json($result);
    } catch (\Exception $e) {
        // Handle any Elasticsearch errors here
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
