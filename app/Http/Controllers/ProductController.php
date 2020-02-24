<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Patterns;
use App\Products;
use App\Comments;
use stdClass;
use \Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showAll()
    {
        $products = Products::with('pattern')->get();
        $response = $products->map(function ($product) {
            $obj = new stdClass();
            $obj->id = $product->id;
            $obj->name = $product->name;
            $obj->imagePath = $product->image_path;
            return $obj;
        });
        return $response;
    }

    public function show($id)
    {
        $product = Products::Pro('comment', 'pattern')->find($id);

        $obj = new stdClass();
        $obj->id = $product->id;
        $obj->name = $product->name;
        $obj->productType = $product->product_type;
        $obj->color = $product->color;
        $obj->ropeSize = $product->rope_size;
        $obj->description = $product->description;
        $obj->imagePath = $product->image_path;
        if ($product->pattern) {
            $obj->videoPath = $product->pattern->video_path;
        } else {
            $obj->videoPath = "none";
        }
        if ($product->comment) {
            $obj->comment = $product->comment;
        } else {
            $obj->comment = [];
        }

        return response()->json($obj);
    }


    public function showPattern($products_id)
    {
        $patterns = Patterns::with('products')
            ->where('products_id', '=', $products_id)->get()->first();
        $response = new stdClass();
        $response->videoPath = $patterns->video_path;
        $response->name = $patterns->products->name;

        return response()->json($response);
    }


    public function showComments($products_id)
    {
        $comments = Comments::where('products_id', '=', $products_id)->get();
        $response = $comments->map(function ($comment) {
            $obj = new stdClass();
            $obj->id = $comment->id;
            $obj->username = $comment->user_name;
            $obj->rating = $comment->rating;
            $obj->opinion = $comment->opinion;

            return $obj;
        });
        return response()->json($response);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'productType' => 'max:100|required',
            'color' => 'max:20',
            'ropeSize' => 'nullable',
            'description' => 'max:1000',
            'imagePath' => 'max:1000',
            'videoPath' => 'required'
        ]);

        if ($validator->fails()) {
            return 'fail';
        }

        $product = new Products;
        $product->name = $request->name;
        $product->product_type = $request->productType;
        $product->color = $request->color;
        $product->rope_size = $request->ropeSize;
        $product->description = $request->description;
        $product->image_path = $request->imagePath;
        $product->save();

        $pattern = new Patterns;
        $pattern->video_path = $request->videoPath;
        $pattern->products_id = $product->id;
        $pattern->save();

        return $product;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'productType' => 'required|max:100|required',
            'color' => 'required|max:20',
            'ropeSize' => 'nullable',
            'description' => 'required|max:1000',
            'imagePath' => 'required|max:1000',
            'videoPath' => 'max:1000'
        ]);

        if ($validator->fails()) {
            return 'fail';
        }

        $product = Products::with('pattern')->find($id);
        $product->name = $request->name;
        $product->product_type = $request->productType;
        $product->color = $request->color;
        $product->rope_size = $request->ropeSize;
        $product->description = $request->description;
        $product->image_path = $request->imagePath;
        $product->save();

        if ($request->videoPath) {
            $product->pattern()->update([
                'video_path' => $request->videoPath
            ]);
        }
        return response()->json();
    }

    public function delete($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return 'product has deleted';
        }
        else {
            $product = Products::where('id', '=', $product->id)->first();

            Patterns::where('products_id', '=', $product->id)->forceDelete();
            Comments::where('products_id', '=', $product->id)->forceDelete();

            $product->forceDelete();
        }

        return response()->json();
    }
}
