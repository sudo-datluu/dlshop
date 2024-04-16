@extends('front.layouts.app')

@section('content')
<section class="section-9 py-4">
    <div class="container">
        <form id="orderForm" name="orderForm" action="" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Delivery details</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Your Name">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="street" id="street" class="form-control" placeholder="Street">
                                        <p></p>
                                    </div>
                                </div>
    
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City/Suburb">
                                        <p></p>
                                    </div>
                                </div>
    
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <select name="state" id="state" class="form-control">
                                            <option value="">Select territories</option>
                                            <option value="1">NSW</option>
                                            <option value="2">VIC</option>
                                            <option value="3">QLD</option>
                                            <option value="4">WA</option>
                                            <option value="5">SA</option>
                                            <option value="6">TAS</option>
                                            <option value="7">ACT</option>
                                            <option value="8">NT</option>
                                            <option value="9">Others</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach(Cart::content() as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                <div class="h6">${{$item->price * $item->qty}}</div>
                            </div>
                            @endforeach
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>$0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Order now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $("#orderForm").submit(function(){
        event.preventDefault();
        $.ajax({
            url: "{{ route('front.processCheckout') }}",
            type: "POST",
            data: $("#orderForm").serialize(),
            success: function(response){
                var errors = response.errors;
                if (errors.name) {
                    $("#name").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.name.join("<br>"))
                } else {
                    $("#name").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html('')
                }

                if (errors.email) {
                    $("#email").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.email.join("<br>"))
                } else {
                    $("#email").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html('')
                }

                if (errors.mobile) {
                    $("#mobile").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.mobile.join("<br>"))
                } else {
                    $("#mobile").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html('')
                }

                if (errors.street) {
                    $("#street").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.street.join("<br>"))
                } else {
                    $("#street").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html('')
                }

                if (errors.city) {
                    $("#city").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.city.join("<br>"))
                } else {
                    $("#city").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html('')
                }
                
                if (errors.state) {
                    $("#state").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.state.join("<br>"))
                } else {
                    $("#state").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html('')
                }
            }
        })
    })
</script>
@endsection