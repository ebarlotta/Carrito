@extends('layout')
 
@section('title', 'Products')
 
@section('content')
 

    <form action="{{ url('create') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-12" style="display:inline-flex; background-color:dark; color:grey;">
            <div class="col-md-6" style="padding-bottom: 10px; padding-top: 10px;">
                <div>Nombre del Producto</div>
                <div><input class="text col-md-12" type="text" name="name" id="name"></div>
                <div style="margin-top: 10px;">Precio del Producto</div>
                <div><input class="col-md-12" step="any" type="number" name="price" id="price"></div>
                <div style="margin-top: 10px;">Tipo de Unidad</div>
                <div>
                    <select class="col-md-12">
                        <option value="Kilos">Kilos</option>
                        <option value="Litros">Litros</option>
                        <option value="Gramos">Gramos</option>
                        <option value="Cm3">Centimentros Cúbicos</option>
                    </select>
                </div>
                <div style="margin-top: 10px;">Imagen</div>
                <div>
                    <input class="col-md-12" id="form-control-file" name="imgProducto" type="file"/>
                </div>
            </div>
            <div class="col-md-6" style="padding-bottom: 10px; padding-top: 10px;">
                <div>Descripcion</div>
                <div>
                    <div>
                        <textarea class="col-md-12" cols="40" rows="9" name="description" id="description"></textarea>
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <div>Cantidad</div>
                </div>
                <div>
                    <div>
                        <input class="col-md-12" step="any" type="number" name="quantity" id="quantity">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="display:inline-flex;">
            <div>Acciones<br></div>
            <div class="col-lg-offset-4 col-lg-3"><input class="btn btn-success col-xs-12 col-sm-12 col-md-12" type="submit" value="Agregar"></div>
            <div class="col-lg-3"><a href="{{ route('index')}}" class="btn btn-info col-xs-12 col-sm-12 col-md-12">Volver</a></div>
        </div>
    </form>

@endsection