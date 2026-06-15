<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class PropertyController extends Controller
{
    public static function getProperties(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        try {
            $perPage = min($per_page, 100);

            $properties = Property::select('id', 'title', 'wp_post_id', 'title', 'content')
                ->orderBy('id')
                ->cursorPaginate($perPage);

            return response()->json([
                'data' => $properties->items(),
                'pagination' => [
                    'per_page' => $properties->perPage(),
                    'next_cursor' => optional($properties->nextCursor())->encode(),
                    'prev_cursor' => optional($properties->previousCursor())->encode(),
                    'has_more_pages' => $properties->hasMorePages(),
                ],
                'message' => 'Enquiries fetched successfully.',
            ], StatusCode::HTTP_OK);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Something went wrong.',
                'errors' => $exception->getMessage(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
