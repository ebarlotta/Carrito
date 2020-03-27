@extends('layout')
 
@section('title', 'Products')
 
@section('content')
 
<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <form action="{{ url('modify',$producto->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <table class="table-dark table" style="vertical-align: baseline; width: 50%;">
                <tr>
                    <td>
                        <table>
                            <th>Nombre del Producto</th>
                            <tr><td><input class="text" type="text" name="name" id="name" value="{{ $producto->name }}"></td></tr>
                            <tr><td>Precio del Producto</td></tr>
                            <tr><td><input step="any" type="number" name="price" id="price" value="{{ $producto->price }}"></td></tr>
                            <tr><td>Tipo de Unidad</td></tr>
                            <tr><td>
                                <select>
                                    <option value="Kilos">Kilos</option>
                                    <option value="Litros">Litros</option>
                                    <option value="Gramos">Gramos</option>
                                    <option value="Cm3">Centimentros Cúbicos</option>
                                </select>
                                </td>
                            </tr>
                            <tr><td>Imagen<img src="{{ asset('images/' . $producto->photo) }}" width="50" height="30" style="margin-left: 30px;"></td></tr>
                            <tr><td>
                                    <input id="form-control-file" name="imgProducto" type="file"/>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: baseline;">
                        <table>
                            <tr><td>Desdcripcion</td></tr>
                            <tr rowcols=4><td>
                                <textarea cols="40" rows="9" name="description" id="description">{{ $producto->description }}</textarea></td>
                            </tr>
                            <tr>
                                <td>Cantidad</td>
                            </tr>
                            <tr>
                                <td><input step="any" type="number" name="quantity" id="quantity" value="{{ $producto->quantity }}"></td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: baseline;">
                        <table>
                            <tr><td>Acciones</td></tr>
                            <tr><td><input class="btn btn-success col-xs-12 col-sm-12 col-md-12" type="submit" value="Modificar"></td></tr>
                            <tr><td><a href="{{ route('index')}}" class="btn btn-info col-xs-12 col-sm-12 col-md-12">Volver</a></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>

 <!--       <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <form action="{{ url('modify',$producto->id) }}" method="get" enctype="multipart/form-data">
                    
                    Modificar el producto {{ $producto->id }}<br>
                    <label for="file"></label>
                    <input type="file" name="file" id="file"><br>
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ $producto->name }}"><br>
                    <label for="description">Descripción</label>
                    <input type="text" name="description" id="description"" value="{{ $producto->description }}"><br>
                    <label for="price">Precio</label>
                    <input type="number" name="price" id="price" value="{{ $producto->price }}"><br>
                    <input type="submit" value="Modificar">
                    </form>
                </div>
        </div> 
        
    </div>-->
 
@endsection