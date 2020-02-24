<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Patterns;
use stdClass;

class PatternController extends Controller
{
    public function showAll()
    {
        $patterns = Patterns::with('products')->get();
        $response = $patterns->map(function ($pattern) {
            $obj = new stdClass();
            $obj->id = $pattern->id;
            $obj->videoPath = $pattern->video_path;
            $obj->productName = $pattern->products->name;
            return $obj;
        });
        return response()->json($response);
    }
}
