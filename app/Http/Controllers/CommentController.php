<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Comments;
use stdClass;
use \Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function showAll()
    {
        $comments = Comments::with('products')->get();
        $response = $comments->map(function ($comments) {
            $obj = new stdClass();
            $obj->id = $comments->id;
            $obj->username = $comments->user_name;
            $obj->rating = $comments->rating;
            $obj->opinion = $comments->opinion;
            $obj->productName = $comments->products->name;
            $obj->imagePath = $comments->products->image_path;

            return $obj;
        });
        return response()->json($response);
    }

    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'opinion' => 'max:1000',
            'username' => 'required',
            'productId' => 'required'
        ]);

        if ($validator->fails()) {
            return 'fail';
        }

        $comment = new Comments;   // czy tutaj jest tworzony nowy element klasy Comments która znajduje się w providers?
        $comment->rating = $request->rating;
        $comment->opinion = $request->opinion;
        $comment->user_name = $request->username;
        $comment->products_id = $request->productId;
        $comment->save(); // dlaczego na końcu musi byc save?

        return response()->json($comment);
    }

}
