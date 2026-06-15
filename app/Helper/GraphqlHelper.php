<?php

namespace App\Helper;
class GraphqlHelper
{
    public static function checkResponseIsSuccess($response, $root_query)
    {
        if ($response->failed()) {
            return [
                'success' => false,
                'message' => 'Request Error',
                'errors' => $response->json()
            ];
        }

        $result = $response->json();

        if (isset($result['errors'])) {
            return [
                'success' => false,
                'message' => 'GraphQL Error',
                'errors' => $result['errors']
            ];
        }

        if (!isset($result['data'][$root_query]['edges'])) {
            return [
                'success' => false,
                'message' => 'GraphQL ran successfully, but the expected data structure was missing.',
                'errors' => $result['errors']
            ];
        }

        return [
            'success' => true,
            'message' => 'GraphQL successful',
        ];
    }
}
