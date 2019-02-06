<?php

namespace App\Http\Controllers\Api\V1\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class OrderUploadImageService extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        try {
            $image = $request->file('image');
            $imageName = md5(uniqid(rand(), true)) . '.' . $image->extension();
            $orderImage = \Image::make($image)->orientate();

            Storage::put('public/orders/tmp/' . $imageName, (string) $orderImage->encode());

            return response()->json([
                'message' => 'Photo was successfully added.',
                'image_name' => $imageName,
                'image_url' => url('/storage/orders/tmp/' . $imageName)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There was an error due to upload image.',
                'error_message' => $e->getMessage(),
            ], 400);
        }
    }
}
