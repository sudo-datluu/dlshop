@extends('front.layouts.app')

@section('content')
<section class=" section-9 pt-4">
    <div class="row">
        @if(Cart::count() > 0)
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table" id="cart">
                    <thead>
                        <tr>
                            <th class="text-start">Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($cartContent))
                        @foreach($cartContent as $item)
                        <tr id="{{$item->rowId}}">
                            <td>
                                <div class="d-flex align-items-start">
                                    <img src="{{ $item->options->first() }}">
                                    <h2>{{$item->name}}</h2>
                                </div>
                            </td>
                            <td>${{$item->price}}</td>
                            <td>
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub-cart" data-id="{{ $item->rowId}}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{$item->qty}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add-cart" data-id="{{ $item->rowId}}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                ${{$item->price * $item->qty}}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="deleteCartItem('{{($item->rowId)}}')"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card cart-summery">
                <div class="sub-title">
                    <h2 class="bg-white">Cart Details</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2">
                        <div>Subtotal</div>
                        <div class="subtotal">${{Cart::subtotal()}}</div>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <div>Shipping</div>
                        <div>$0</div>
                    </div>
                    <div class="d-flex justify-content-between summery-end">
                        <div>Total</div>
                        <div class="subtotal">${{Cart::subtotal()}}</div>
                    </div>
                    <div class="pt-5">
                        <a href="{{ route('front.checkout') }}" class="btn-dark btn btn-block w-100">Checkout</a>
                    </div>
                    <div class="pt-2">
                        <button onclick="clearCart()" class="btn-danger btn btn-block w-100">Clear your cart</button>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flext justify-contetn-center align-itemc-center">
                    <h4>Your cart is empty</h4>
                </div>
            </div>
        </div>
        @endif
    </div>

</section>
@endsection

@section('customJs')
<script>
    $('.add-cart').click(function() {
        var qtyElement = $(this).parent().prev();
        var qtyValue = parseInt(qtyElement.val());

        qtyElement.val(qtyValue + 1);
        var rowId = $(this).data('id');
        var newQty = qtyElement.val();
        updateCart(rowId, newQty)
    });

    $('.sub-cart').click(function() {
        var qtyElement = $(this).parent().next();
        var qtyValue = parseInt(qtyElement.val());
        if (qtyValue > 1) {
            qtyElement.val(qtyValue - 1);
            var rowId = $(this).data('id');
            var newQty = qtyElement.val();
            updateCart(rowId, newQty)
        }
    });

    function updateCart(rowId, qty) {
        $.ajax({
            url: "{{ route('front.updateCart') }}",
            type: "POST",
            data: {
                rowId: rowId,
                qty: qty
            },
            success: function(response) {
                $('.subtotal').text('$' + response.newSubtotal);
            }
        });
    }

    function deleteCartItem(rowId) {
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: "{{ route('front.deleteCartItem') }}",
                type: "POST",
                data: {
                    rowId: rowId,
                },
                dataType: "json",
                success: function(response) {
                    $('#' + rowId).remove();
                    $('.subtotal').text('$' + response.newSubtotal);
                }
            });
        }
    }

    function clearCart() {
        if (confirm("Are you sure you want to clear your cart?")) {
            $.ajax({
                url: "{{ route('front.clearCart') }}",
                type: "POST",
                dataType: "json",
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    }
</script>
@endsection