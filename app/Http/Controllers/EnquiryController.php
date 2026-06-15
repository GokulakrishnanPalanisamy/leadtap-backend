<?php

namespace App\Http\Controllers;

use App\Events\EnquiryCreated;
use App\Helper\EnquiryHelper;
use App\Http\Requests\EnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class EnquiryController extends Controller
{
    public static function createEnquiry(EnquiryRequest $request)
    {
        $validated = $request->validated();

        try {

            // checking data present within 24 hours.
            if (EnquiryHelper::checkDataPresentwithin24Hours($validated)) {
                return response()->json([
                    'message' => 'Try After 24 hours'
                ], StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }

            $enquiry_data = Enquiry::create($validated);

            EnquiryCreated::dispatch($enquiry_data);

            return response()->json([
                'data' => [
                    'uuid' => $enquiry_data->uuid,
                    'name' => $enquiry_data->name,
                    'email' => $enquiry_data->email,
                    'phone' => $enquiry_data->phone,
                    'message' => $enquiry_data->message,
                    'status' => $enquiry_data->status,
                    'wp_post_id' => $enquiry_data->wp_post_id,
                ],
                'message' => 'Enquiry successfully created.'

            ], StatusCode::HTTP_CREATED);

        } catch (\Exception $exception) {

            return response()->json([
                'error' => $exception->getMessage()
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

    public static function getEnquiry($uuid)
    {
        try {

            $enquiry = Cache::remember('enquiry-' . $uuid, now()->addMinutes(30), function () use ($uuid) {
                return Enquiry::select('uuid', 'name', 'email', 'phone', 'message', 'status', 'wp_post_id')
                    ->where('uuid', $uuid)
                    ->firstOrFail()
                    ->toArray();
                });

            return response()->json([
                'data' => $enquiry,
                'message' => 'Enquiry fetched.'
            ], StatusCode::HTTP_OK);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Enquiry not found.'
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Something went wrong.'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public static function getEnquiries(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        try {
            $perPage = min($per_page, 100);

            $enquiries = Enquiry::select('id', 'uuid', 'name', 'email', 'phone', 'message', 'status', 'wp_post_id', 'created_at')
                        ->orderBy('id')
                        ->cursorPaginate($perPage);

            return response()->json([
                'data' => $enquiries->items(),
                'pagination' => [
                    'per_page' => $enquiries->perPage(),
                    'next_cursor' => optional($enquiries->nextCursor())->encode(),
                    'prev_cursor' => optional($enquiries->previousCursor())->encode(),
                    'has_more_pages' => $enquiries->hasMorePages(),
                ],
                'message' => 'Enquiries fetched successfully.',
            ], StatusCode::HTTP_OK);

        } catch (\Exception $exception) {

            return response()->json([
                'message' => 'Something went wrong.'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
