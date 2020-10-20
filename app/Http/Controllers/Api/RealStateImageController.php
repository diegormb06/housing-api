<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealStateImages;
use App\Api\ApiMessages;
use exception;

class RealStateImageController extends Controller
{
    /**
     * @var RealStateImages
     */
    private $realStateImages;

    public function __construct(RealStateImages $realStateImages)
    {
        $this->realStateImages = $realStateImages;
    }

    public function setThumb($imageId, $realStateId)
    {
        try {
            $image = $this->realStateImages
                ->where('real_state_id', $realStateId)
                ->where('is_thumb', true)->first();

            if ($image) $image->update(['is_thumb' => false]);

            $newThumb = $this->realStateImages->find($imageId);
            $newThumb->update(['is_thumb' => true]);

            return response()->json([
                "message" => "Thumb changed successful",
            ], 200);

        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function remove($imageId)
    {
        try {
            $image = $this->realStateImages->find($imageId);

            if($image) {
                \Storage::disk('public')->delete($image->photo);
                $image->delete();
            }

            return response()->json([
                "message" => "Image deleted successful",
            ], 200);

        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}
