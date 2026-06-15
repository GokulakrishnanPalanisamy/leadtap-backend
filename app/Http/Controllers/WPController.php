<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Helper\GraphqlHelper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class WPController extends Controller
{
    public static function syncWPContent()
    {
        try {

            $query = require base_path('graphql-queries/fetch-posts.php');

            $response = Http::withHeaders([
                'Host' => config('services.wordpress.host'),
                'Content-Type' => 'application/json',
            ])->post(config('services.wordpress.url'), [
                'query' => $query,
            ]);

            $root_query = 'posts';

            $result = GraphqlHelper::checkResponseIsSuccess($response, $root_query);

            if (!$result['success']) {
                return response()->json([
                    'message' => $result['message'],
                    'errors' => $result['errors']
                ], StatusCode::HTTP_BAD_REQUEST);
            }

            $raw_content = $response->json();

            foreach ($raw_content['data'][$root_query]['edges'] as $post) {
                Property::updateOrCreate(
                    [
                        'wp_post_id' => $post['node']['databaseId'],
                    ],
                    [
                        'title'   => $post['node']['title'],
                        'content' => $post['node']['content'],
                    ]
                );
            }

            return response()->json([
                'message' => 'Synced with wordpress posts',
            ], StatusCode::HTTP_CREATED);


        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Something went wrong',
                'errors' => $e->getMessage(),
            ], statusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
