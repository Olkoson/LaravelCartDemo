<?php
namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Show products list
     *
     * @return Response
     */
    public function showAll()
    {
        $products = Product::all();
        $itemsCount = Cart::where('user_id', 1)->count();
        return view('products', ['products' => $products, 'items_count' => $itemsCount]);
    }
}