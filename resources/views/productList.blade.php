@extends('layout')
 
@section('title', 'Products')
 
@section('content')
 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table-holder table-responsive table-dark">
                    <thead style="text-align:center">
                        <th style="text-align:center">Imagen</th>
                        <th style="text-align:center">Nombre</th>
                        <th style="text-align:center">Precio</th>
                        <th style="text-align:center">Acción</th>
                    </thead>
                    <tbody>
                        
                        @foreach($products as $product)
                        <tr>
                            <td><img src="{{ asset('images/' . $product->photo) }}" width="50" height="30"></td>
                            <td>{{ $product->name }}</td>
                            <td> $ {{ $product->price }}</td>
                            <td>
                                <a href="{{ route('modificar',$product->id) }}" class="btn btn-success">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                <a href="{{ route('delete', $product->id) }}" class="btn btn-danger">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                            <td><p class="btn-holder" style="margin-bottom: 0rem;"><a href="{{ url('addProduct/'.$product->id) }}" class="btn btn-warning btn-block text-center" role="button">Agregar a Carrito</a> </p></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- End row -->
        {{ $products->links() }}
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-12">
	    <a href="{{ route('index')}}" class="btn btn-info">Volver</a>
    </div>

@endsection