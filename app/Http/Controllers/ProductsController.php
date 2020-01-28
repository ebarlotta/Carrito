<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(3);
        //$products = Product::all()->paginate(15);
        return view('products', compact('products'));
    }
 
    public function cart()
    {
        return view('cart');
    }

    


    public function addToCart($id)
    {
        $product = Product::find($id);
    
        if(!$product) {
            abort(404);
        }
    
        $cart = session()->get('cart');
    
        // if cart is empty then this the first product
        if(!$cart) {
    
            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => $product->photo
                    ]
            ];
    
            session()->put('cart', $cart);
    
            return redirect()->back()->with('success', 'Producto agregado al carrito correctamente!');
        }
    
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
    
            $cart[$id]['quantity']++;
    
            session()->put('cart', $cart);
    
            return redirect()->back()->with('success', 'Producto agregado al carrito correctamente!');
    
        }
    
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];
    
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'Producto agregado al carrito correctamente!');
    }

    public function update(Request $request)
        {
            if($request->id and $request->quantity)
            {
                $cart = session()->get('cart');
     
                $cart[$request->id]["quantity"] = $request->quantity;
     
                session()->put('cart', $cart);
     
                session()->flash('success', 'Producto Actualizado!');
            }
        }
     
        public function remove(Request $request)
        {
            if($request->id) {
     
                $cart = session()->get('cart');
     
                if(isset($cart[$request->id])) {
     
                    unset($cart[$request->id]);
     
                    session()->put('cart', $cart);
                }
     
                session()->flash('success', 'Producto removido correctamente');
            }
        }

}
