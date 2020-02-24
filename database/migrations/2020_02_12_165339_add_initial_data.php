<?php

use App\Patterns;
use App\Products;
use App\Comments;
use Illuminate\Database\Migrations\Migration;

class AddInitialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $product = new Products;
        $product->name = 'Mała czerwona torebka';
        $product->product_type = 'torebka';
        $product->color = 'czerwony';
        $product->rope_size = 3;
        $product->description = 'ext, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).';
        $product->image_path = 'https://anesart.pl/wp-content/uploads/2019/10/20191011_Czerwona-torebka_03.jpg';
        $product->save();

        $pattern = new Patterns;
        $pattern->video_path = 'https://www.youtube.com/watch?v=HX3kRRVlLiI&t=25s';
        $pattern->products_id = $product->id;
        $pattern->save();


        $comment = new Comments;
        $comment->rating = 5;
        $comment->opinion = 'It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.;';
        $comment->user_name = 'Zofia';
        $comment->products_id = $product->id;
        $comment->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $product = Products::where('name', '=', 'Mała czerwona torebka')->first();

        Patterns::where('products_id', '=', $product->id)->delete();
        Comments::where('products_id', '=', $product->id)->delete();
        $product->delete();
//
//        $product->forceDelete();
    }
}
