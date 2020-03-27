@extends('layout')
 
@section('title', 'Cart')
 
@section('content')
 
    <table id="cart" class="table table-hover table-condensed" style="background-color:dark; color:burlywood;">
        <thead>
        <tr>
            <th style="width:50%">Producto</th>
            <th style="width:10%">Precio</th>
            <th style="width:8%">Cantidad</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>
 
        <?php $total = 0 ?>
 
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
 
                <?php $total += $details['price'] * $details['quantity'] ?>

                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs">
                                <img src="{{ asset('images/' . $details['photo']) }}" width="100" height="100" class="img-responsive"/>
                            </div>
                            <div class="col-sm-9">
                                <h4 class="nomargin" style="font-size:1.3em;word-wrap: break-word;">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    
                    <td data-th="Price">${{ $details['price'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                    </td>
                    <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
 
        </tbody>
        <tfoot>
        <tr class="visible-xs">
            <td class="text-center"><strong>Total {{ $total }}</strong></td>
        </tr>
        <tr>
            <td><a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuar Comprando</a></td>
            <td>
            <!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> -->

                <!-- Identify your business so that you can collect the payments. -->
                <!--<input type="hidden" name="business" value="enzobarlotta@gmail.com">-->

                <!-- Specify a Buy Now button. -->
                <!--<input type="hidden" name="cmd" value="_xclick">-->

                <!-- Specify details about the item that buyers will purchase. -->
                <!--<input type="hidden" name="item_name" value="Hot Sauce-12oz. Bottle">
                <input type="hidden" name="amount" value="5.95">
                <input type="hidden" name="currency_code" value="USD">-->

                <!-- Display the payment button. -->
                <!--<input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="Comprar Ahora">
                <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
            </form>-->
            <!--<script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
<script>paypal.Buttons().render('body');</script>-->
            
            <a href="{{ route('payment') }}" class="btn btn-success">PAGAR</a>

            </td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>
        </tr>
        </tfoot>
    </table>
@endsection


@section('scripts')
  
    <script type="text/javascript">
 
        $(".update-cart").click(function (e) {
           e.preventDefault();
 
           var ele = $(this);
 
            $.ajax({
               url: '{{ url('update-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
 
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
 
            var ele = $(this);
 
            if(confirm("Estás seguro de eliminar el producto?")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

        $(".update-cart").click(function (e) {
            e.preventDefault();
 
            var ele = $(this);
 
            if(confirm("Actualizaste los datos del producto?")) {
                /*$.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "PUT",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });*/
            }
        });
 
    </script>
 
@endsection