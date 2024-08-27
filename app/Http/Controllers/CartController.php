<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return response()->json($carts);
    }

    public function create(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $cart = Cart::create(['user_id' => $request->input('user_id')]);
        return response()->json($cart, 201);
    }

    public function addItem(Request $request, $cartId)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Proceed with adding the item if validation passes
        $cartItem = CartItem::create([
            'cart_id' => $cartId,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity')
        ]);

        return response()->json($cartItem, 201);
    }

    public function getCart($cartId)
    {
        $cart = Cart::with('items')->find($cartId);
        if ($cart) {
            return response()->json($cart);
        } else {
            return response()->json(['message' => 'Cart not found'], 404);
        }
    }

    public function removeItem($cartId, $itemId)
    {
        $cartItem = CartItem::where('cart_id', $cartId)->find($itemId);
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Item removed']);
        } else {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }
}
