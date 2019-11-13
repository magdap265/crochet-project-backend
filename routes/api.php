<?php

use Illuminate\Http\Request;
use App\Product;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/products', function(){

    //połączneie do bazy danych
    // wyciągniecie danychh z bazy
    //obrobienie danych
    //return danych

//   return [
//       'fn'=> 'Janusz',
//       'ln'=> 'Kowalski'
//   ];
    $products = Product::orderBy('created_at', 'asc')->get();
    return $products;
});

Route::post('/product', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'description' => 'max:1000',
        'price' => 'required',
        'image' => 'required'
    ]);

    if ($validator->fails()) {
        return 'fail';
    }

    $product = new Product;
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->image = $request->image;
    $product->save();

    return $product;
});
