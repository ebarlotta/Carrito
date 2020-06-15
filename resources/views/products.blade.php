@extends('layout')
 
@section('title', 'Products')

@if(session('message'))
    @include('message')
@endif

@section('content')
 
        <div class="row">
 
            @foreach($products as $product)
                <div class="col-xs-12 col-sm-1 col-md-6 col-lg-4">
                    <div class="thumbnail" style="color:burlywood">
                        <!-- 768x294 <img src="{{ asset('images/' . $product->photo) }}" width="350" height="200">-->
                        <img src="{{ asset('images/' . $product->photo) }}" width="175" height="200">
                        <div class="caption">
                            <h3>{{ $product->name }}</h3>
                            <p style="font-size:1.1em;">{{ strtolower($product->description) }}</p>
                            <p><strong>Precio: </strong> {{ $product->price }}$</p>
                            <p class="btn-holder"><a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning btn-block text-center" role="button">Agregar a Carrito</a> </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div><!-- End row -->
        {{ $products->links() }}
    </div>
 
@endsection