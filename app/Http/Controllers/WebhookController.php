<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebhookRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class WebhookController extends Controller
{
    public function updateStatus(WebhookRequest $request)
    {
        $validated = $request->validated();

        try {
            $enquiry = Enquiry::where('uuid', $validated['uuid'])->first();

            $enquiry->update([
                'status' => $validated['status'],
            ]);

            Cache::forget('enquiry-' . $validated['uuid']);

            return response()->json([
                'message' => 'Webhook processed.',
            ], StatusCode::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Sorry, something went wrong.',
                'error' => $th->getMessage(),
            ], StatusCode::HTTP_BAD_REQUEST);

        }
    }
}
