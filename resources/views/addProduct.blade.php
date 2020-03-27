@extends('layout')
 
@section('title', 'Products')
 
@section('content')
 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <form action="{{ url('create') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <table class="table-dark table" style="vertical-align: baseline; width: 50%;">
                <tr>
                    <td>
                        <table>
                            <th>Nombre del Producto</th>
                            <tr><td><input class="text" type="text" name="name" id="name"></td></tr>
                            <tr><td>Precio del Producto</td></tr>
                            <tr><td><input step="any" type="number" name="price" id="price"></td></tr>
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
                            <tr><td>Imagen</td></tr>
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
                                <textarea cols="40" rows="9" name="description" id="description"></textarea></td>
                            </tr>
                            <tr>
                                <td>Cantidad</td>
                            </tr>
                            <tr>
                                <td><input step="any" type="number" name="quantity" id="quantity"></td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: baseline;">
                        <table>
                            <tr><td>Acciones</td></tr>
                            <tr><td><input class="btn btn-success col-xs-12 col-sm-12 col-md-12" type="submit" value="Agregar"></td></tr>
                            <tr><td><a href="{{ route('index')}}" class="btn btn-info col-xs-12 col-sm-12 col-md-12">Volver</a></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>

@endsection