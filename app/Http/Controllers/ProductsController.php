<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::OrderBy('name','ASC')
            ->paginate(4); 
        return view('products', compact('products'));
    }

    public function FiltrarProductos(request $Request) {
        if($Request->filtro) { 
            $name=$Request->filtro;
            $products = Product::OrderBy('name','ASC')
                ->where('name','like',"%$name%")
                ->paginate(4); 
        }
        else {
            $products = Product::OrderBy('name','ASC')
                ->paginate(4);
        }
        return view('products', compact('products'));
    }

    public function ListarProductos()
    {
        $products = Product::paginate(7);
        return view('productList', compact('products'));
    }

    public function create(request $Request) {
        
        $producto = new Product;
        $producto->name = $Request->name;
        $producto->description = $Request->description;
        $producto->price = $Request->price;
        $producto->quantity = $Request->quantity;
        
        if($Request->hasFile('imgProducto')) {
            $file=$Request->file('imgProducto');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/',$name);
        }

        $producto->photo = $name;
        $producto->save();

        return redirect('product')->with('success', 'Producto agregado');
    }

    public function add(){
        return view('addProduct');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('product')->with('success', 'Post is deleted!');
    }

    public function modify($id)
    {
        $producto = Product::findOrFail($id);
        return view('updateProduct',compact('producto'));
    }
    
    public function updateProd(request $Request)
    {
        $producto = Product::findOrFail($Request->id);
        $producto->name = $Request->name;
        $producto->description = $Request->description;
        $producto->price = $Request->price;

        //$producto->photo = $Request->photo; //Carga el nombre del archivo original

        if($Request->hasFile('imgProducto')) {  //Si ha sido modificado el campo, entonces carga un nuevo archivo
            $file=$Request->file('imgProducto');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/',$name);
            $producto->photo = $name;
        }

        $producto->update();
        return redirect('product')->with('success', 'Producto Actualizado!');
        
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
                        "id"=>$product->id,
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
            "id"=>$product->id,
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
