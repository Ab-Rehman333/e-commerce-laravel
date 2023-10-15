<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TemporaryController extends Controller
{
    public function create(Request $request)
    {
        $image = $request->image;

        if (!empty($image)) {
            $imgName = $image->getClientOriginalName();
            $newName = time() . '. ' . $imgName;

            $tem_images = new TempImage();
            $tem_images->name = $newName;
            $tem_images->save();

            $image->move(public_path() . '/temp', $newName);
            return response()->json([
                'status' => true,
                'image_id' => $tem_images->id,
                'message' => 'Image UPloaded Successfully'
            ]);
        }
    }
}
