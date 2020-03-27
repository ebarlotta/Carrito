@extends('layout')
 
@section('title', 'Products')

@if(session('message'))
    @include('message')
@endif

@section('content')
 
        <div class="row">
 
            @foreach($products as $product)
                <div class="col-xs-18 col-sm-6 col-md-3">
                    <div class="thumbnail" style="color:burlywood">
                        <img src="{{ asset('images/' . $product->photo) }}" width="500" height="300">
                        <div class="caption">
                            <h4>{{ $product->name }}</h4>
                            <p>{{ strtolower($product->description) }}</p>
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