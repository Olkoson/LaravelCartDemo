<?php
namespace App\Http\Controllers;

use App\Cart;
use App\Library\Services\DiscountServiceInterface;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    //TODO implement increase/decrease product quantity

    /**
     * show cart
     * @param DiscountServiceInterface $discountService
     *
     * @return View
     */
    public function show(DiscountServiceInterface $discountService)
    {
        $products = [];
        $totalPrice = 0;
        $userId = 1;
        $discount = 0;
        $itemsInBasket = Cart::where('user_id', $userId)->get();

        foreach ($itemsInBasket as $key => $item) {
            $product = Product::find($item->product_id);
            $products[$key]['id'] = $item->id;
            $products[$key]['quantity'] = $item->quantity;
            $products[$key]['name'] = $product->name;
            $products[$key]['price'] = $item->price;
            $totalPrice += $item->price * $item->quantity;
        }

        //TODO move discount block to a separate service
        $discountBogof = $discountService->calculateDiscountBogof($itemsInBasket);
        $orderPrice = $totalPrice - $discountBogof;
        $discount += $discountBogof;

        $discountGreaterThan = $discountService->calculateDiscountGreater($orderPrice);
        $orderPrice = $orderPrice - $discountGreaterThan;
        $discount += $discountGreaterThan;

        $discountLoyalty = $discountService->calculateDiscountLoyalty($userId, $orderPrice);
        $orderPrice = $orderPrice - $discountLoyalty;
        $discount += $discountLoyalty;

        return view('cart', ['products' => $products, 'products_count' => count($products),
            'total_price' => $totalPrice, 'discount' => $discount, 'order_price' => $orderPrice]);
    }

    /**
     * add product to cart
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = $request->input('user_id', 1);

        $product = Product::find($productId);

        $cart =  Cart::where('product_id', $productId)->first();
        if ($cart) {
            $cart->increment('quantity');
        } else {
            $cart = new Cart();
            $cart->product_id = $productId;
            $cart->user_id = $userId;
            $cart->price = $product->price;
            $cart->save();
        }

        return redirect()->route('products');
    }

    /**
     * add product to cart
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function remove(Request $request)
    {
        $id = $request->input('id');

        Cart::destroy($id);

        return redirect()->route('cart');
    }

    /**
     * remove all products from cart
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function clear(Request $request)
    {
        $userId = $request->input('user_id');

        $delete = Cart::where('user_id', $userId)->delete();

        return redirect()->route('cart');
    }
}